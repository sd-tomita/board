<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TestController extends Sdx_Controller_Action_Http
{
  public function formTestAction()
  {
    /* *
     * 目的　以下のテストをしたい
     * ・Sdx_Form でフォームを作成
     * ・submit後にフォームに値が入った状態を維持
     */
    $form = new Sdx_Form();
    $form
      ->setActionCurrentPage()
      ->setMethodToPost();      
    
    //ジャンル名。ラジオボタンでつくる。
    $elem = new Sdx_Form_Element_Group_Radio();
    $elem
      ->setName('genre')
      ->addChildren(
        Bd_Orm_Main_Genre::createTable()->getSelect()->fetchPairs()
        /* * 
         * メモ 
         * fetchPairs()はペアでとってくる。
         * カラムを指定しないと先頭と2番目の組み合わせになるみたいなので
         * もっとカラム数が多いテーブルからSelectする際は、SetColumns()で
         * ペアにするカラムの指定と、どっちが key でどっちが value になるかの
         * 順番の指定もあったほうがよさげ。今回はカラム数少ないので省略。
         */
    );
    
    $form->setElement($elem);
    
    //タグ名。こっちはチェックボックスでつくる。
    $elem = new Sdx_Form_Element_Group_Checkbox();
    $elem
      ->setName('tag')
      ->addChildren(
        Bd_Orm_Main_Tag::createTable()->getSelect()->fetchPairs()
    );
    $form->setElement($elem);
    
    //formから送信されたパラメータが既にあればここでbindされる。
    $form->bind($this->_getAllParams());

    $this->view->assign('form', $form);
    
    //テスト用ダンプ(いらなくなったら消す)
    $genre_dump = 
      Bd_Orm_Main_Genre::createTable()->getSelect()->fetchPairs();          
    Sdx_Debug::dump($genre_dump,'ジャンル名配列');

    $tag_dump = 
      Bd_Orm_Main_Tag::createTable()->getSelect()->fetchPairs();       
    Sdx_Debug::dump($tag_dump,'タグ名配列');        
  }
}

