<?php
class EntryController extends Sdx_Controller_Action_Http
{
    public function commentAction()
    {
        //これを動かすとテンプレによるレンダリングが
        //行われないので、テンプレを使いたいときは
        //_disableViewRenderer()はコメントアウトする。
        //$this->_disableViewRenderer();
        
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
        
        //fetchAll()で全て取得して$entryへ入れておく
        $entry = $t_entry->fetchAll($select);
               
        //$entryの内容をテンプレに渡す。
        $this->view->assign("entry_list", $entry);
        
        //確認用のダンプ出力。公開時は消すが、$entry_listに
        //格納されているメソッドを見ながら作業できるので、
        //ひとまず書いておく。
        //この時点ではインスタンスの出力がされればおｋ
        Sdx_Debug::dump($entry, "Sdx_Debug::dumpの出力結果");
        
    }
}
?>
