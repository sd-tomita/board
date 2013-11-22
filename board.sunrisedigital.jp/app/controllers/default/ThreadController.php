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
      $select->order('thread_id ASC');
      $select->add("thread.id", $this->_getParam('thread_id'));
      Sdx_Debug::dump($select->assemble(), 'じっけん');
      $entry = $t_entry->fetchAll($select);
      $this->view->assign("entry_list", $entry);
      
      //コメント投稿関係
      $form = $this->createForm();
      
      //Validateエラー時のメッセージを出力させるためのif文
      $error_params = $this->_createSession();
      if(isset($error_params->e_params))
      {
        $form->bind($error_params->e_params);
        $form->execValidate();
        unset($error_params->e_params);
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
          $error_params = $this->_createSession();
          $error_params->e_params = $this->_getAllParams();  
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
