<?php

abstract class Bd_Orm_Main_Base_Form_Entry extends Sdx_Form
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
    public static function createThreadIdElement()
    {
        return new Sdx_Form_Element_Text(array('name'=>'thread_id'));
    }

    public static function createThreadIdValidator(Sdx_Form_Element $element)
    {
        $element->addValidator(new Sdx_Validate_NotEmpty());
    }

    /**
     * @return Sdx_Form_Element
     */
    public static function createBodyElement()
    {
        return new Sdx_Form_Element_Text(array('name'=>'body'));
    }

    public static function createBodyValidator(Sdx_Form_Element $element)
    {
        $element->addValidator(new Sdx_Validate_NotEmpty());$element->addValidator(new Sdx_Validate_StringLength(array('max'=>255)));
    }

    /**
     * @return Sdx_Form_Element
     */
    public static function createAccountIdElement()
    {
        return new Sdx_Form_Element_Text(array('name'=>'account_id'));
    }

    public static function createAccountIdValidator(Sdx_Form_Element $element)
    {
        $element->addValidator(new Sdx_Validate_NotEmpty());
    }

    protected function _init()
    {
        $this->setName('entry');
        $this->setAttribute('method', 'POST');
        if(!in_array('id', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_Entry', 'createIdElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_Entry', 'createIdValidator'), $element);
        }
        
        if(!in_array('thread_id', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_Entry', 'createThreadIdElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_Entry', 'createThreadIdValidator'), $element);
        }
        
        if(!in_array('body', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_Entry', 'createBodyElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_Entry', 'createBodyValidator'), $element);
        }
        
        
        
        if(!in_array('account_id', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_Entry', 'createAccountIdElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_Entry', 'createAccountIdValidator'), $element);
        }
    }

    /**
     * @return Bd_Orm_Main_Table_Entry
     */
    public function getTable()
    {
        return call_user_func(array('Bd_Orm_Main_Entry', 'getTable'));
    }

    /**
     * @return Bd_Orm_Main_Table_Entry
     */
    public function createTable()
    {
        return call_user_func(array('Bd_Orm_Main_Entry', 'createTable'));
    }

    /**
     * @return Bd_Orm_Main_Entry
     */
    public function createRecord()
    {
        return new Bd_Orm_Main_Entry();
    }


}

