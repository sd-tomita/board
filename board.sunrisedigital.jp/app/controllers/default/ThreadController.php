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
    public function threadListAction()
    {
      /*
       * ここにIndexControllerのindexAction()で行っていた
       * スレッド全件を出す処理を書く。
       * そのときにスレッドID、タグIDはGET形式で送信し、
       * GETの値があれば絞り込んでリストを出すようにする。
       */
               
      //サブクエリ用
      $t_entry = Bd_Orm_Main_Entry::createTable();
      $sub_sel = $t_entry->getSelect();
      $sub_sel->group('thread_id');

      $sub_sel->resetColumns();
      $sub_sel->columns(array(
        0 => 'thread_id', 
        'newest_date' => 'MAX(entry.created_at)'
      ));
      Sdx_Debug::dump($sub_sel->assemble(), '$sub_selのSQL');
  
      //こっちがメインのSelect。これに必要なテーブルをjoinしていく
      $t_thread = Bd_Orm_Main_Thread::createTable();
      $main_sel = $t_thread->getSelectWithJoin();
                       
      //ネストされるSQL文の外側を()で囲うためだけのものです。
      $sub = sprintf('(%s)', $sub_sel->assemble());
      //本Selectにjoinする。
      $main_sel->joinLeft(
        array('sub' => new Zend_Db_Expr($sub)) ,
        'thread.id = sub.thread_id'
      );
      
      //$_GET['genre_id']があればjoinする
      if($this->_getParam('genre_id'))
      {
        $t_genre = Bd_Orm_Main_Genre::createTable();
        $main_sel->joinInner('genre', 'thread.genre_id = genre.id');
        
        //同じ名前のカラムが複数存在してしまうのを防ぐための処理
        $main_sel
          ->resetColumns()
          ->columns(array(
              'thread.id', 
              'thread.title', 
              'thread.created_at', 
              'thread.genre_id', 
              'sub.*', 
              'genre.name'
          ));
        
        $main_sel->add('thread.genre_id', $this->_getParam('genre_id'));      
      }
      
      //$_GET['tag_id']があればjoinする
      if($this->_getParam('tag_id'))
      {
        $t_threadtag = Bd_Orm_Main_ThreadTag::createTable();
        $t_tag = Bd_Orm_Main_Tag::createTable();
        $main_sel
          ->joinInner('thread_tag', 'thread.id = thread_tag.thread_id')
          ->joinInner('tag', 'thread_tag.tag_id = tag.id');
        $main_sel
          ->resetColumns()
          ->columns(array(
            'thread.id', 
            'thread.title', 
            'thread.created_at', 
            'sub.*', 
            'tag.name'
          ));
        $main_sel->add('thread_tag.tag_id', $this->_getParam('tag_id'));
      }
         
      //joinがひととおり終わったら最後に順番を指定してfetchAll()
      $main_sel->order('newest_date DESC');
      $thread = $t_thread->fetchAll($main_sel);
                    
      Sdx_Debug::dump($main_sel->assemble(), '$main_selのSQL');//assembleでSelect結果を配列化
            
      $this->view->assign("thread_list", $thread);
    
    }
    public function listAction()
    {
      /*
       * ここでは以下SQL文を生成しようとしている。
       * SELECT * FROM entry 
       * LEFT JOIN account ON account_id = account.id
       * LEFT JOIN thread ON thread_id = thread.id
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
      Sdx_Debug::dump($select->assemble(), 'SQL文');
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
} 
?>
