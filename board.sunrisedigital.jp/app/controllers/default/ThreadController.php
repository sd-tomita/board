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
      //ログインチェック
      if(!(Sdx_User::getInstance()->hasId()))
      {
        $this->forward500();
      }
      
      //投稿回数チェック
      //規定投稿回数に達しているときは、tpl側でsubmitボタン隠すので本来は不要のチェック。
      //submitボタンを介さないスクリプト攻撃対策。なので500に飛ばす。
      if(isset($_COOKIE['stop_entry']))
      {
        $this->forward500();
      }
      
      //submitされていれば
      if($this->_getParam('submit'))
      {
        $form = $this->createForm();

        //bindする前に、入力された内容が空白「のみ」だったら空白をカットする
        $str = $this->_getParam('body');//入力されたコメント
        $trimed_str = preg_replace("/^[　\s]+$/u", "", $str);//置換条件はまだ未設定。
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
     * カウント開始クッキーがあったら、カウントをアップする。  
     * カウント開始クッキーがなければ新規発行する。  
     * クッキーの生存中に次回投稿があれば連続投稿とみなす。  
     * カウントが規定回数に達した時点で、また別に投稿ストップ用クッキーを出す。  
     */
    private function _setPostCounter()
    {
      $entry_count = new Sdx_Session('ENTRY_POST_COUNT');
      
      //カウンターが無ければ作成し、既にあればカウントアップ
      if(!isset($_COOKIE['post_cookie']))
      {
        $expire = time()+1*30;//クッキーの有効期限。30秒は微妙かも。
        $value = "連続投稿制限中";//特にvalue自体はなくてもいいが一応構文通りの値を入れとく
        setcookie('post_cookie', $value, $expire);
        $entry_count->total = 1;//これが初期値
      }
      else
      {      
        $entry_count->total +=1;
      }

      //カウント数が規定回数に達していたら投稿制限用のクッキーを発行。
      if($entry_count->total === 3)
      {
        setcookie('stop_entry','規定エントリ回数到達' ,time()+180);
        unset($entry_count->total);//カウント用セッションはいらないので消す
      }
    }
} 
?>
