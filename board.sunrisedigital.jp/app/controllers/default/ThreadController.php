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
    public function listAction()
    {
      //URLからthread_idを取得。
      //なお、thread_idはroute.ymlに付けた変数名。
      //$num = $this->_getParam('thread_id');変数を使う必要なくなったのでコメントアウト
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
      //ORDER BY thread_id ASC(thread_idを昇順でSELECT)
      $select->order('thread_id ASC');
      //URLから受け取ったID分だけをSelectするよう条件追記
      $select->add("thread.id", $this->_getParam('thread_id'));
      //fetchAll()で全て取得して$entryへ入れておく
      $entry = $t_entry->fetchAll($select);
      //$entryの内容をテンプレに渡す。
      $this->view->assign("entry_list", $entry);
        
      //確認用ダンプ出力。いらなくなったら消す
      //Sdx_Debug::dump($entry, '$entryの出力結果');
      //Sdx_Debug::dump($_SESSION, '$_SESSIONの出力結果');
      //Sdx_Debug::dump($_SESSION["Sdx_Auth"]["storage"]["id"], '$_SESSION内値の出力結果');
        
      //コメント投稿関係はこっちのメソッドに任せる。
      $form = $this->createForm();
      Sdx_Debug::dump($form, '$formの出力結果');
      
      //Validateエラー時のメッセージを出力させるためのif文
      if(isset($_SESSION['form']))
      {
        $form->bind($_SESSION['form']);
        $form->execValidate();
        unset($_SESSION['form']);
      }
      $this->view->assign('form', $form);
    }
    private function createForm()
    {
      $form = new Sdx_Form();//インスタンス作成
      $form
        ->setAction('/thread/'.$this->_getParam('thread_id').'/save-entry') //アクション先を設定
        ->setMethodToPost();     //メソッドをポストに変更
 
      //各エレメントをフォームにセット
                //アカウントIDのフォーム自体をなくす。
                //$elem = new Sdx_Form_Element_Hidden();
                //$elem
                //  ->setName('account_id');
                  //->addValidator(new Sdx_Validate_NotEmpty('何も入力ないのは寂しいです'))
                  //->addValidator(new Sdx_Validate_Regexp('/^[0-9]+$/u','つかえるのは数字だけね'));
                //$form->setElement($elem);
      //コメント
      $elem = new Sdx_Form_Element_Textarea();
      $elem
        ->setName('body')
        //とりあえずコメントだけなのでNULL値チェックだけでよいかと。
        ->addValidator(new Sdx_Validate_NotEmpty('何も入力ないのは寂しいです'));
      $form->setElement($elem);
       
      return $form;
    }
    public function saveEntryAction()
    {
      //ログインチェック
      //認証されたユーザーはhasId()にtrueが返る。
      if(!(Sdx_User::getInstance()->hasId()))
      {
        $this->forward500();
      }
      if($this->_getParam('submit'))
      {
        $form = $this->createForm();
        //Validateを実行するためにformに値をセット
        //エラーが有った時各エレメントに値を戻す処理も兼ねてます
        //bindメソッドは主に取得したパラメータを配列にしてセット
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
              //->setAccountId(sprintf('%d', $_SESSION["Sdx_Auth"]["storage"]["id"]));
              ->setAccountId(Sdx_Context::getInstance()->getVar('signed_account')->getId());//$_SESSIONから直接とらないように。
            $entry->save();
            $db->commit();
            $this->redirectAfterSave("thread/{$this->_getParam('thread_id')}/list");
          }
          catch (Exception $e)
          {
            $db->rollBack();
            throw $e;
          }
        }
        else
        {
          $_SESSION['form'] = $this->_getAllParams();
          $this->redirectAfterSave("thread/{$this->_getParam('thread_id')}/list#entry-form");
        }
      }
      else
      {
      $this->redirectAfterSave("thread/{$this->_getParam('thread_id')}/list#entry-form");
      }         
    }
} 
?>
