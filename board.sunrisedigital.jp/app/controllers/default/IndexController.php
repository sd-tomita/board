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
            $this->_disableViewRenderer();
            
            //threadテーブルクラスの取得
            $t_thread = Bd_Orm_Main_Thread::createTable();
            //selectの取得
            $select = $t_thread->getSelect();
            //SQLの発行
            $list = $t_thread->fetchAll($select);
            
            Sdx_Debug::dump($list, 'kaeriti');
            Sdx_Debug::dump($list->toArray, 'record');
        }
        
}