<?php
class ThreadController extends Sdx_Controller_Action_Http
{   
    public function indexAction()
    {
      Sdx_Debug::dump($this->_getParam('thread_id'), 'title');
    }
    public function addAction()
    {
        
    }
    
    public function deleteAction()
    {
        
    }
    /*
     * スレッド一覧はthreadListActionに集約する。
     * どういう条件で検索されても、全てこのアクションで
     * 処理を行い、レコードリストを返すようにする。
     */
    public function threadListAction()
    {   
      /* *
       * ①全スレッド取得
       * エントリがあった順
       */
      
      //サブクエリ  
      $t_entry = Bd_Orm_Main_Entry::createTable();
      $sub_sel = $t_entry->getSelect();
      $sub_sel->group('thread_id');
      $sub_sel
        ->setColumns('thread_id')
        ->columns(array('newest_date' => 'MAX(entry.created_at)')
      );
      $sub = sprintf('(%s)', $sub_sel->assemble());

      //こっちがメインセレクト
      $t_thread = Bd_Orm_Main_Thread::createTable();
      $main_sel = $t_thread->getSelectWithJoin();
      $main_sel->joinLeft(
        array('sub' => new Zend_Db_Expr($sub)) ,
        'thread.id = sub.thread_id'
      );

      /* *
       * ②ジャンルで絞りこみをかけたい場合
       * テーブル内に既にgenre_idがあるのでそれを使う
       */
      if($this->_getParam('genre_id'))
      {
        $main_sel->add('genre_id', $this->_getParam('genre_id')); 
      
        //検索されているジャンルが何かを表示する用
        $t_genre = Bd_Orm_Main_Genre::createTable();
        $genre_sel = $t_genre->getSelect();
        $genre_sel->setColumns('name')->add('id',  $this->_getParam('genre_id'));
        $this->view->assign('genre_name',$genre_name = $t_genre->find($genre_sel));
      }
    
      /* *
       * ③タグも絞込みに使いたい場合。
       * 絞込みに必要なスレッドID番号群を取得する。
       */
      if($this->_getParam('tag_id'))
      {
        $t_threadtag = Bd_Orm_Main_ThreadTag::createTable();
        $tag_sel = $t_threadtag->addJoinInner($t_thread)->getSelectWithJoin();
        
        $tag_sel
          ->setColumns('thread_id')
          ->add('tag_id', $this->_getParam('tag_id'))
          ->group('thread_id')
          ->having('COUNT(tag_id) ='.count($this->_getParam('tag_id')));
      
        //タグ未指定時にエラーになるのを防ぐためif文の中で$main_selにadd
        $main_sel
        ->add('id', $tag_sel->fetchCol());
        
        //検索されているタグが何かを表示する用
        $t_tag = Bd_Orm_Main_Tag::createTable();
        $tag_sel = $t_tag->getSelect(); 
        $tag_sel->setColumns()->columns('name')->add('id', $this->_getParam('tag_id'));
        $this->view->assign('tag_names',$tag_names = $t_tag->fetchAll($tag_sel));
      }
      
      /* *
       * ④最後にレコードの取得件数と並び順を指定して
       * レコードリストを取得する
       */
      //１ページには10行まで。$main_selが総数
      $pager = new Sdx_Pager(10, $t_thread->count($main_sel));      
      $this->view->assign('pager', $pager);//これはページオブジェクトのアサイン

      $main_sel
        ->limitPager($pager)
        ->order(array(
            new Zend_Db_Expr('CASE when newest_date IS NULL then 1 else 2 END ASC'), 
            'newest_date DESC')
        );

      $thread_list = $t_thread->fetchAll($main_sel);
      $this->view->assign('thread_list', $thread_list);
    }
    public function listAction()
    {
      /*
       * ここでは以下SQL文を生成しようとしている。
       * SELECT * FROM entry 
       * LEFT JOIN account ON account_id = account.id
       * LEFT JOIN thread ON ｔthread_id = thread.id
       * WHERE thread.id = "thread_idのパラメータ値"
       * ORDER BY entry.created_at ASC;
       */  
        
      //entryテーブルクラスの取得
      $t_entry = Bd_Orm_Main_Entry::createTable();

      //JOIN予定のAccountテーブルのテーブルクラスを取得
      $t_account = Bd_Orm_Main_Account::createTable();
      $t_thread = Bd_Orm_Main_Thread::createTable();
      
      //JOIN
      $t_entry->addJoinLeft($t_account);
      $t_entry->addJoinLeft($t_thread);
                
      //selectを取得
      $select = $t_entry->getSelectWithJoin();
      $select->order('entry.created_at ASC');
      $select->add("thread.id", $this->_getParam('thread_id'));
      $entry = $t_entry->fetchAll($select);
      $this->view->assign("entry_list", $entry);
      
      //コメント投稿関係
      $form = $this->createForm();
      
      //Validateエラー時のメッセージを出力させるためのif文
      $error_session = $this->_createSession();
      if(isset($error_session->params))
      {
        $form->bind($error_session->params);
        $form->execValidate();
        unset($error_session->params);
      }

      $this->view->assign('form', $form);
    }
    private function createForm()
    {
      $form = new Sdx_Form();
      $form
        ->setAction('/thread/'.$this->_getParam('thread_id').'/save-entry') //アクション先を設定
        ->setMethodToPost();     //メソッドをポストに変更
 
      //エレメントをフォームにセット
      $elem = new Sdx_Form_Element_Textarea();
      $elem
        ->setName('body')
        ->addValidator(new Sdx_Validate_NotEmpty('何も入力ないのは寂しいです'));
      $form->setElement($elem);
       
      return $form;
    }
    public function saveEntryAction()
    {
      //ログインチェック
      if(!(Sdx_User::getInstance()->hasId()))
      {
        $this->forward500();
      }
      
      //submitされていれば
      if($this->_getParam('submit'))
      {
        $form = $this->createForm();

        //Validateを実行するためにformに値をセット
        $form->bind($this->_getAllParams());
                
        //Validate実行。trueならトランザクション開始
        if($form->execValidate())
        {
          $entry = new Bd_Orm_Main_Entry();//データベース入出力関係のクラスはこっちにある。
          $db = $entry->updateConnection();
          $db->beginTransaction();
 
          try
          {
            $entry
              ->setBody($this->_getParam('body'))
              ->setThreadId($this->_getParam('thread_id'))
              ->setAccountId(Sdx_Context::getInstance()->getVar('signed_account')->getId());//$_SESSIONから直接とらないように。
            $entry->save();
            $db->commit();  
          }
          catch (Exception $e)
          {
            $db->rollBack();
            throw $e;
          }
        }
        else
        {
          $error_session = $this->_createSession();
          $error_session->params = $this->_getAllParams();  
        }
      }
      $this->redirectAfterSave("thread/{$this->_getParam('thread_id')}/list#entry-form");         
    }
    //Sdx_Session() は Zend_Session_Namespace の使い方とほぼ同じ。
    private function _createSession()
    {
      //引数がキー名になる。省略するとdefaultキーになる。
      return new Sdx_Session('THREAD_POST_FORM');    
    }
    /*
     * jquery.ajaxを使ったリストの取得を行うメソッド
     * とりあえずは置いてみるだけ。
     */
    public function useAjaxAction() 
    {
      Sdx_Debug::dump('test', $GLOBALS);
    } 
} 
?>
