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
            //テンプレを反映させるため、_disableViewRendererは
            //一旦コメントアウトしています。
            //$this->_disableViewRenderer();
            
            //threadテーブルクラスの取得
            $t_thread = Bd_Orm_Main_Thread::createTable();
            
            //レコードの並び順を指定したいのでSelectを使う。
            $select = $t_thread->getSelect();
            $select->order('id DESC');//新しい投稿順
            $thread = $t_thread->fetchAll($select);
            /*foreach ($thread as $record)
            {
                Sdx_Debug::dump($record->getTitle(), '繰り返しスレッド一覧');
            }*/
            
            //結果を出力。テンプレができたらここはもう消す
            //Sdx_Debug::dump($thread, 'スレッド一覧');
            
            //テンプレで使えるように$threadの内容をテンプレにアサインする。
            $this->view->assign("thread_list", $thread);
        }
        
}