<?php

abstract class Bd_Orm_Main_Base_Form_Thread extends Sdx_Form
{

    private $_except_list = array();

    public function __construct($name = "", array $attributes = array(), array $except_list = array())
    {
        $this->_except_list = $except_list;
        parent::__construct($name, $attributes);
    }

    /**
     * @return Sdx_Form_Element
     */
    public static function createIdElement()
    {
        return new Sdx_Form_Element_Hidden(array('name'=>'id'));
    }

    public static function createIdValidator(Sdx_Form_Element $element)
    {
        
    }

    /**
     * @return Sdx_Form_Element
     */
    public static function createTitleElement()
    {
        return new Sdx_Form_Element_Text(array('name'=>'title'));
    }

    public static function createTitleValidator(Sdx_Form_Element $element)
    {
        $element->addValidator(new Sdx_Validate_NotEmpty());$element->addValidator(new Sdx_Validate_StringLength(array('max'=>80)));
    }

    protected function _init()
    {
        $this->setName('thread');
        $this->setAttribute('method', 'POST');
        if(!in_array('id', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_Thread', 'createIdElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_Thread', 'createIdValidator'), $element);
        }
        
        if(!in_array('title', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_Thread', 'createTitleElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_Thread', 'createTitleValidator'), $element);
        }
    }

    /**
     * @return Bd_Orm_Main_Table_Thread
     */
    public function getTable()
    {
        return call_user_func(array('Bd_Orm_Main_Thread', 'getTable'));
    }

    /**
     * @return Bd_Orm_Main_Table_Thread
     */
    public function createTable()
    {
        return call_user_func(array('Bd_Orm_Main_Thread', 'createTable'));
    }

    /**
     * @return Bd_Orm_Main_Thread
     */
    public function createRecord()
    {
        return new Bd_Orm_Main_Thread();
    }


}

