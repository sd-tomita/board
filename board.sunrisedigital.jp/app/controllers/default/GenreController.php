<?php
/**
 *
 *
 * @author  Yuichiro Tomita <sunrisedigitaltomita@gmail.com>
 * @create  2013/11/21
 * @copyright 2013 Sunrise Digital Corporation.
 * @version  v 1.0 2013/11/21 17:25 tomita
 **/
class GenreController extends Sdx_Controller_Action_Http
{
  public function listAction()
  {
    $t_genre = Bd_Orm_Main_Genre::createTable();
    $t_thread = Bd_Orm_Main_Thread::createTable();
    
    //join
    $t_thread->addJoinInner($t_genre);
    
    //Select
    $select = $t_thread->getSelectWithJoin();
    $select->add("genre_id", $this->_getParam('genre_id'));
    Sdx_Debug::dump($select->assemble(), 'SQL文');
    
    //fetchAllしてテンプレにアサイン。
    $thread_list = $t_thread->fetchAll($select);
    $this->view->assign('thread_list', $thread_list);
  }
}
?>
