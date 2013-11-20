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
                       
    //ネストする用のSelect
    //　↓これを Sdx_Db_Select でつくりたい！
    //(SELECT thread_id, MAX(entry.updated_at) AS newest_date FROM entry GROUP BY thread_id) AS sub
    $sub_sel = $t_entry->getSelect();
    $sub_sel->group('thread_id');

    $sub_sel->resetColumns();//getSelect()でデフォルトで設定されているSELECTの対象「*」をリセット
    $sub_sel->columns(array(
      0 => 'thread_id',//連想配列で統一するため敢えてキー｢0｣を付けているだけ。 
      'newest_date' => 'MAX(entry.created_at)'
    ));
    Sdx_Debug::dump($sub_sel->assemble(), '$sub_selのSQL');
  
    //本selectの作成
    $select = $t_thread->getSelectWithJoin();
                       
    //ネストされるSQL文の外側を()で囲うためだけのものです。
    $sub = sprintf('(%s)', $sub_sel->assemble());
    //本Selectにjoinする。
    $select->joinLeft(
      array('sub' => new Zend_Db_Expr($sub)) ,
      'thread.id = sub.thread_id'
    );
                 
    $select->order('newest_date DESC');
    $thread = $t_thread->fetchAll($select);
                    
    Sdx_Debug::dump($select->assemble(), '$selectのSQL');//assembleでSelect結果を配列化
            
    $this->view->assign("thread_list", $thread);
  }
}