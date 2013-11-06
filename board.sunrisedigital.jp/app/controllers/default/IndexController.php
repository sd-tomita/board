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
          //直接SQL文を発行。これだとレコードは取得できてもテーブルクラスが取得できないのでやっぱりなし。
          //$db = Bd_Db::getConnection('board_master');
          //$thread = $db->query
          //('SELECT * FROM thread INNER JOIN 
          //(SELECT thread_id, MAX(entry.created_at) AS newest_date 
          //FROM entry GROUP BY thread_id) AS sub 
          //ON thread.id = sub.thread_id ORDER BY sub.newest_date DESC')->fetchAll();
         
            //テーブルクラスの取得
            $t_thread = Bd_Orm_Main_Thread::createTable();
            $t_entry = Bd_Orm_Main_Entry::createTable();
            
            //inner join
            $t_thread->addJoinInner($t_entry);

            //selectの作成
            $select = $t_thread->getSelectWithJoin();
            //$select->joinInner();
      
            
            $select->order('id DESC');
            //$thread = $t_thread->fetchAll($select);
         
            Sdx_Debug::dump($select->assemble(), 'dump');//assembleでSelect結果を配列化
            
            //テンプレで使えるように$threadの内容をテンプレにアサインする。
            //$this->view->assign("thread_list", $thread);
        }
        
}