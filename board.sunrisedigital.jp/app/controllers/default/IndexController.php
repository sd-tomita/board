<?php
/**
 *
 *
 * @author  Masamoto Miyata <miyata@able.ocn.ne.jp>
 * @create  2010/03/21
 * @copyright 2007 Sunrise Digital Corporation.
 * @version  v 1.0 2010/03/21 18:50:08 Miyata
 **/

class IndexController extends Sdx_Controller_Action_Http
{
  public function indexAction()
  {    
    $this->view->assign('genre_list', Bd_Orm_Main_Genre::createTable()->fetchAllOrdered('id','DESC'));
    $this->view->assign('tag_list', Bd_Orm_Main_Tag::createTable()->fetchAllOrdered('id','DESC'));
  }
}