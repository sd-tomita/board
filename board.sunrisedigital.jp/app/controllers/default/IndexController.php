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
            //テーブルクラスの取得
            $t_thread = Bd_Orm_Main_Thread::createTable();
            $t_entry = Bd_Orm_Main_Entry::createTable();
            
            //inner join
            //$t_thread->addJoinInner($t_entry);

            //selectの作成
            $select = $t_thread->getSelectWithJoin();
            
            //まずグループ化。
            $select->group('thread_id');
            
            //書き方がわからなかったのでSQLインジェクション対策は一旦置いてます。
            $select->joinLeft('entry as sub', 'thread.id = sub.thread_id', 'thread.id,  max(sub.created_at) as newest_date');
            
            $select->order('newest_date DESC');
            $thread = $t_thread->fetchAll($select);
         
            Sdx_Debug::dump($select->assemble(), 'dump');//assembleでSelect結果を配列化
            
            //テンプレで使えるように$threadの内容をテンプレにアサインする。
            $this->view->assign("thread_list", $thread);
        }
        
}