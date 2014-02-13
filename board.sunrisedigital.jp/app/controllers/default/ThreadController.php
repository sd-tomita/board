<?php
class ThreadController extends Sdx_Controller_Action_Http
{
    /**
     * setPostCounter()で使用
     * 連続投稿と見なす投稿間隔
     */
    const POST_INTERVAL = 30;
    
    /**
     * setPostCounter()で使用
     * 連続投稿回数の上限値
     */
    const MAX_POST_COUNT = 3;
    
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
       * JSON で値の配列だけを送信するようにするため
       * テンプレによるレンダリングは止めておく。
       * (HTMLタグが付与されるのを防ぐ)
       */
      $this->_disableViewRenderer();
      
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
        ->addColumns(array('newest_date' => 'MAX(entry.created_at)')
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
      }
      
      /* *
       * ④最後にレコードの取得件数と並び順を指定して
       * レコードリストを取得する
       */
      //１ページには10行まで。$main_selが総数
      $pager = new Sdx_Pager(5, $t_thread->count($main_sel)); 
      $this->view->assign('pager', $pager);//これはページオブジェクトのアサイン     
      
      $main_sel
        ->limitPager($pager)
        ->order(
          array(
            new Zend_Db_Expr('CASE when newest_date IS NULL then 1 else 2 END ASC'), 
            'newest_date DESC', 
            'created_at DESC'
          )
        );

      $thread_list = $t_thread->fetchAll($main_sel);
      
      /* *
       * json関係。selectしたレコードの内容と次ページIDを返す
       */

      //jsonで返すためのdataを用意。レコード情報と次ページID
      $data = array(
        'records' => $thread_list->toArray(), 
        'next_pid' => $pager->getNextPageId()
      );
      
      //json_encodeしてレスポンスも返す。自分でecho不要。
      $this->jsonResponse($data);
      
      /* ---------------------------------------------
       * レスポンスヘッダを編集などしたいときは、以下の手法も可。
       * $this->jsonResponse()の中で行われている処理とほぼ同じ。
       * 
       * $resp = $this->getResponse();
       * $resp
       *   ->setHeader('Content-type','application/json')
       *   ->setBody(json_encode($data)
       * );
       --------------------------------------------- */
    }
    /**
     * エントリとエントリ作成者の情報を取る
     * SELECT * FROM entry
     * LEFT JOIN account ON account_id = account.id
     * ORDER BY entry.created_at;
     * 
     * スレッド名、スレッド番号表示に必要な情報はjoinいらないので別にとる
     * SELECT * FROM thread WHERE id=スレッド番号;
     */
    public function entryListAction()
    {
      //entryテーブルクラスの取得
      $t_entry = Bd_Orm_Main_Entry::createTable();

      //JOIN予定のAccountテーブルのテーブルクラスを取得
      $t_account = Bd_Orm_Main_Account::createTable();
      
      //JOIN
      $t_entry->addJoinLeft($t_account);
                
      //selectを取得
      $select = $t_entry->getSelectWithJoin();
      $select
        ->order('entry.created_at ASC')
        ->add('thread_id', $this->_getParam('thread_id'));
      
      //エントリ情報をアサイン
      $entry_list = $t_entry->fetchAll($select);
      $this->view->assign('entry_list', $entry_list);
      
      //Threadテーブルの情報は別に送る。ここでは1個しかとってないからfetchAll()じゃなくてfind()でおｋ。
      $t_thread = Bd_Orm_Main_Thread::createTable();
      $thread_select = $t_thread
        ->getSelect()->add('id', $this->_getParam('thread_id'));
      $this->view->assign('thread_info', $t_thread->find($thread_select));
      
      //フォームは別メソッドでつくる。
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
      $this->_disableViewRenderer();
      //ログインチェック
      if(!(Sdx_User::getInstance()->hasId()))
      {
        $this->forward500();
      }
      
      //投稿制限中かどうかのチェック
      if(Sdx_User::getInstance()->getAttribute('post_count')=='stop_entry')
      {
        $this->forward500();
      }
      
      //submitされていれば
      if($this->_getParam('submit'))
      {
        $form = $this->createForm();

        //bindする前に、入力された内容が空白「のみ」だったら空白をカットする
        $str = $this->_getParam('body');
        $trimed_str = preg_replace("/^[　\s]+$/u", "", $str);
        $this->_setParam('body', $trimed_str);
        
        //Validateを実行するためにformに値をセット
        $form->bind($this->_getAllParams());
                
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
          //連続投稿回数のカウンターを仕込む
          $this->_setPostCounter();
        }
        else
        {
          $error_session = $this->_createSession();
          $error_session->params = $this->_getAllParams();  
        }
      }     
      $this->redirectAfterSave("thread/{$this->_getParam('thread_id')}/entry-list#entry-form");         
    }
    //Sdx_Session() は Zend_Session_Namespace の使い方とほぼ同じ。
    private function _createSession()
    {
      //引数がキー名になる。省略するとdefaultキーになる。
      return new Sdx_Session('THREAD_POST_FORM');    
    }

    public function searchAction() 
    {
      $this->view->assign('genre_list', Bd_Orm_Main_Genre::createTable()->fetchAllOrdered('id','DESC'));
      $this->view->assign('tag_list', Bd_Orm_Main_Tag::createTable()->fetchAllOrdered('id','DESC'));
    }
    
    /**
     * 連続投稿回数のカウンター
     * 
     * 初回投稿から30秒以内に次回投稿があった場合、連続投稿とみなし
     * カウントする。連続投稿カウントが3つまでいったら、投稿を停止
     * させるフラグを立てる。(あとはsaveEntry()の頭でフラグの有無で
     * 投稿させるかはじくかを判断させる)
     * 
     * 言い換えるなら30秒以上間隔を空けながらコメント投稿すれば
     * カウントが進むことはないとも言える。 
     */
    private function _setPostCounter()
    {
      $user = Sdx_User::getInstance();
      
      //カウンターが無ければ作成し、既にあれば比較する
      if(!$user->getAttribute('post_time'))
      {
        $first_post_time = time();
        $user->setAttribute('post_time', $first_post_time);//ここがスタート地点
        $user->setAttribute('post_count', 1);//count初期値
      }
      else
      { 
        $current_time = time();
        /**
         * 初回投稿から30秒以内の投稿ならカウントを上げる。
         * 30秒以上経っていた場合は初回投稿時刻の更新だけ行い、
         * 連続投稿かどうかのチェックは次回に以降に持ち越す。
         */
        if(($current_time - $user->getAttribute('post_time')) <= self::POST_INTERVAL)
        {
          $post_count = $user->getAttribute('post_count');
          $user->setAttribute('post_count', $post_count+1);
        }
        elseif(($current_time - $user->getAttribute('post_time')) > self::POST_INTERVAL)
        {
          //初回の'post_time'をクリアする
          $user->setAttribute('post_time', $current_time);
        }
      }

      //カウント数が規定回数に達していたら
      if($user->getAttribute('post_count') === self::MAX_POST_COUNT)
      {
        $user->setAttribute('post_count','stop_entry');//投稿ストップさせる
        $user->deleteAttribute('post_time');
      }
    }
} 
?>
