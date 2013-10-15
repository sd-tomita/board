<?php

abstract class Bd_Orm_Main_Base_Form_AutoLogin extends Sdx_Form
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
    public static function createHashElement()
    {
        return new Sdx_Form_Element_Hidden(array('name'=>'hash'));
    }

    public static function createHashValidator(Sdx_Form_Element $element)
    {
        $element->addValidator(new Sdx_Validate_StringLength(array('max'=>190)));
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

    /**
     * @return Sdx_Form_Element
     */
    public static function createExpireDateElement()
    {
        return new Sdx_Form_Element_Text(array('name'=>'expire_date'));
    }

    public static function createExpireDateValidator(Sdx_Form_Element $element)
    {
        $element->addValidator(new Sdx_Validate_NotEmpty());
    }

    protected function _init()
    {
        $this->setName('auto_login');
        $this->setAttribute('method', 'POST');
        if(!in_array('hash', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_AutoLogin', 'createHashElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_AutoLogin', 'createHashValidator'), $element);
        }
        
        if(!in_array('account_id', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_AutoLogin', 'createAccountIdElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_AutoLogin', 'createAccountIdValidator'), $element);
        }
        
        if(!in_array('expire_date', $this->_except_list))
        {
        	$element = call_user_func(array('Bd_Orm_Main_Form_AutoLogin', 'createExpireDateElement'));
        	$this->setElement($element);
        	call_user_func(array('Bd_Orm_Main_Form_AutoLogin', 'createExpireDateValidator'), $element);
        }
    }

    /**
     * @return Bd_Orm_Main_Table_AutoLogin
     */
    public function getTable()
    {
        return call_user_func(array('Bd_Orm_Main_AutoLogin', 'getTable'));
    }

    /**
     * @return Bd_Orm_Main_Table_AutoLogin
     */
    public function createTable()
    {
        return call_user_func(array('Bd_Orm_Main_AutoLogin', 'createTable'));
    }

    /**
     * @return Bd_Orm_Main_AutoLogin
     */
    public function createRecord()
    {
        return new Bd_Orm_Main_AutoLogin();
    }


}

