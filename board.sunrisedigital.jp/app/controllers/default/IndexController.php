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
            //主キーで取得。DBへの接続トランザクションは見るだけなので必要なし。
            //なお、全部取得したいので、引数を考える。
            //↓の代わりにコメントアウト$thread = $t_thread->findByPkey(6);
            $thread = $t_thread->getSelect();
            //結果を出力
            Sdx_Debug::dump($thread->toArray(), 'Pkey');
            //selectの取得
            $select = $t_thread->getSelect();
            //SQLの発行
            $list = $t_thread->fetchAll($select);
            
            Sdx_Debug::dump($list, 'kaeriti');
            Sdx_Debug::dump($list->toArray, 'record');
        }
        
}