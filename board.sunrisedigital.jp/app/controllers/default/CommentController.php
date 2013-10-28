<?php
class CommentController extends Sdx_Controller_Action_Http
{
    public function commentAction()
    {
        $this->_disableViewRenderer();
        
        //entryテーブルクラスの取得
        $t_entry = Bd_Orm_Main_Entry::createTable();
        
    }
}
?>
