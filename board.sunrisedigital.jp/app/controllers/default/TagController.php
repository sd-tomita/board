<?php
/**
 *
 *
 * @author  Yuichiro Tomita <sunrisedigitaltomita@gmail.com>
 * @create  2013/11/22
 * @copyright 2013 Sunrise Digital Corporation.
 * @version  v 1.0 2013/11/22 11:08 tomita
 **/
class TagController extends Sdx_Controller_Action_Http
{
  public function listAction()
  {
    $t_tag = Bd_Orm_Main_Tag::createTable();
    $t_thread_tag = Bd_Orm_Main_ThreadTag::createTable();
    $t_thread = Bd_Orm_Main_Thread::createTable();
    
    //join
    $t_thread_tag->addJoinInner($t_thread);
    $t_thread_tag->addJoinInner($t_tag);
    
    //Select
    $select = $t_thread_tag->getSelectWithJoin();
    $select->add("tag_id", $this->_getParam('tag_id'));
    Sdx_Debug::dump($select->assemble(), 'SQL文');
    
    //fetchAllしてテンプレにアサイン。
    $thread_list = $t_thread_tag->fetchAll($select);
    $this->view->assign('thread_list', $thread_list);
  }
}
?>