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
        $num = $this->_getParam('thread_id');
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
        $select->where("thread.id = $num");
         //fetchAll()で全て取得して$entryへ入れておく
        $entry = $t_entry->fetchAll($select);
        //$entryの内容をテンプレに渡す。
        $this->view->assign("entry_list", $entry);
        
        //確認用ダンプ出力。いらなくなったら消す
        //Sdx_Debug::dump($entry, '$entryの出力結果');
        
        //フォームを作るメソッドは
        $this->formCreation();
    }
    private function formCreation()
    {
        $form = new Sdx_Form();//インスタンス作成
        $form
        ->setAction('comment') //アクション先をthread/commentに設定
        ->setMethodToPost();     //メソッドをポストに変更
 
        //各エレメントをフォームにセット
        //コメント
        $elem = new Sdx_Form_Element_Textarea();
        $elem
                ->setName('body')
                ->addValidator(new Sdx_Validate_NotEmpty());
        $form->setElement($elem);
 
        $this->view->assign('form', $form);
    }
}
?>
