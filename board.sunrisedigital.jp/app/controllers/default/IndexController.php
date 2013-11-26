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
    
    //ジャンル一覧とタグ一覧に使うレコードはこっちで取得する。
    $this->_subMenu();
  }
  //ジャンル名とタグ名をTOPに出すためのレコードを取得するメソッド
  private function _subMenu()
  {
     //ジャンルとタグのテーブルクラス
    $t_genre = Bd_Orm_Main_Genre::createTable();
    $t_tag = Bd_Orm_Main_Tag::createTable();
    
    //ジャンルのレコード
    $genre_select = $t_genre->getSelect()->order('id DESC');
    $genre_list = $t_genre->fetchAll($genre_select);
    $this->view->assign('genre_list', $genre_list);
    
    //タグのレコード
    $tag_select = $t_tag->getSelect()->order('id DESC');
    $tag_list = $t_tag->fetchAll($tag_select);
    $this->view->assign('tag_list', $tag_list);
  }
  //作ってはみたものの、あまり効率化にならなかったので下記メソッドは使用しないことにします。
//  private function _simpleSelect($sometable_class)
//  {
//    $sometable_class->getSelect()->order('id DESC');
//    return $this;
//  }
}