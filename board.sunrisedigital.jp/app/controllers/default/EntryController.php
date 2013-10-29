<?php
class EntryController extends Sdx_Controller_Action_Http
{
    public function commentAction()
    {
        $this->_disableViewRenderer();
        
        //entryテーブルクラスの取得
        $t_entry = Bd_Orm_Main_Entry::createTable();
        //ひとまずfetchAll()で全て取得して$entryへ入れておく
        $entry = $t_entry->fetchAll();
               
        //$entryの内容をテンプレに渡しておく
        $this->view->assign("entry_list", $entry);
        
        //確認用のダンプ出力。公開時は消す
        Sdx_Debug::dump($entry, "Sdx_Debug::dumpの出力結果");
        
    }
}
?>
