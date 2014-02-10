<?php

/**
 *
 *
 * @author  Masamoto Miyata <miyata@able.ocn.ne.jp>
 * @create  2011/12/21
 * @version  v 1.0 2011/12/21 18:50:08 Miyata
 * */
class SecureController extends Sdx_Controller_Action_Http {

  public function loginAction() {
    $this->_initHelper();

    //デフォルトのリダイレクト先
    $fixed_url = '/';

    //既にサブミットされていれば
    if($this->_getParam('submit'))
    {
      $ref_info = $this->_createSession();
      //セッションがあったらしまう
      if(isset($ref_info->url))
      {
        $fixed_url = $ref_info->url;
        unset($ref_info->url);
      }
    }
    //サブミットされる前だったら
    else if(isset($_SERVER['HTTP_REFERER'])) 
    {
      //リファラのURLを解析
      $parsed_url = parse_url($_SERVER['HTTP_REFERER']);
      
      //リファラのパスが/secure/login、/secure/logout以外ならセッションにしまう
      if (!in_array($parsed_url['path'],array('/secure/login', '/secure/logout'))) 
      {
        $ref_info = $this->_createSession();
        $ref_info->url = $_SERVER['HTTP_REFERER'];
      }
    }

    $this->_helper->secure->login($fixed_url);
    
  }
  
  private function _createSession()
  {
    return new Sdx_Session('URL');
  }
  
  public function logoutAction() {
    $this->_initHelper();
    $this->_helper->secure->logout();
  }

  public function denyAction() {
    
  }

  private function _initHelper() {
    $helper = new Bd_Controller_Action_Helper_Secure();
    $this->addHelper($helper);

    $helper
      ->setIdElement(new Sdx_Form_Element_Text(array(
        'name' => 'login_id',
      )))
      ->setPasswordElement(new Sdx_Form_Element_Password(array(
        'name' => 'password',
    )));
  }

}