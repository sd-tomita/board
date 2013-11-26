<?php

require_once 'Bd/Orm/Main/Base/Form/Thread.php';

class Bd_Orm_Main_Form_Thread extends Bd_Orm_Main_Base_Form_Thread
{
  public static function createGenreIdElement()
  {
    $elem = new Sdx_Form_Element_Group_Select(array('name'=>'genre_id'));
    $select = Bd_Orm_Main_Genre::getTable()->getSelect()
      ->resetColumns()
      ->columns(array('id', 'name'))
      ->order('sequence ASC');
    $elem->setChildren($select->fetchPairs());
    $elem->setDefaultEmptyChild('ジャンルを選択して下さい');
    return $elem;
  }
  public static function createMMTagIdElement()
  {
    $elem = new Sdx_Form_Element_Group_Checkbox(array('name'=>'Tag__id'));
    $select = Bd_Orm_Main_Tag::getTable()->getSelect()
      ->resetColumns()
      ->columns(array('id', 'name'))
      ->order('id ASC');
    $elem->setChildren($select->fetchPairs());
    return $elem;
  }
}

