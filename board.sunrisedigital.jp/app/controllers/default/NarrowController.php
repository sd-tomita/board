<?php
class NarrowController extends Sdx_Controller_Action_Http
{
    //genreテーブルにジャンルを追加するためのメソッドです。
    //Scaffoldでつくるまでのまにあわせ。
    public function genreCreateAction()
    {
        $form = new Sdx_Form();//インスタンスを作成
        $form
                ->setActionCurrentPage()//アクション先を現在のURLに設定
                ->setMethodToPost();//メソッドをPOSTに変更
       
        //各エレメントをフォームにセット
        //name
        $t_genre = Bd_Orm_Main_Genre::createTable();
        $elem = new Sdx_Form_Element_Text();
        $elem
                ->setName('name')
                ->addValidator(new Sdx_Validate_NotEmpty());//入力値があるかどうか
        $form->setElement($elem);
        
        //sequence
        $elem = new Sdx_Form_Element_Text();
        $elem
                ->setName('sequence')
                ->addValidator(new Sdx_Validate_NotEmpty())
                ->addValidator(new Sdx_Validate_Regexp(
                        '/^[0-9]+$/u',
                        '数字のみ使用可能です')
                );
        $form->setElement($elem);
        
      //submitされていれば
      if($this->_getParam('submit'))
      {
        //Validateを実行するためにformに値をセット
        $form->bind($this->_getAllParams());
                
        //Validate実行。trueならトランザクション開始
        if($form->execValidate())
        {
          $genre = new Bd_Orm_Main_Genre();//データベース入出力関係のクラスはこっちにある。
          $db = $genre->updateConnection();
          $db->beginTransaction();
 
          try
          {
            $genre
              ->setName($this->_getParam('name'))
              ->setSequence($this->_getParam('sequence'));
            $genre->save();
            $db->commit();
          }
          catch (Exception $e)
          {
            $db->rollBack();
            throw $e;
          }
          $this->redirectAfterSave("/narrow/genre-create");
        }  
      }
       
      $this->view->assign('form', $form);  
  }
  public function genreAction()
  {
    $t_genre = Bd_Orm_Main_Genre::createTable();
    $t_thread = Bd_Orm_Main_Thread::createTable();
      
    //selectを取得
    $select = $t_genre->getSelectWithJoin();
    $select->joinLeft($t_thread);
  }
  public function tagAction()
  {
    $t_tag = Bd_Orm_Main_Tag::createTable();
    $t_thread = Bd_Orm_Main_Thread::createTable();
      
    //selectを取得
    $select = $t_tag->getSelectWithJoin();
    $select->joinLeft($t_thread);
  }          
}
?>
