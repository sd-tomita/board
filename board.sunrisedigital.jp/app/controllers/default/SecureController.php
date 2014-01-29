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

    //そもそも遷移元が存在しない(URL直打ち等)場合はTOPに飛ばす
    if (!isset($_SERVER['HTTP_REFERER'])) {
      $ref_info = $this->_createSession();
      $ref_info->url = '/'; 
    }

    //ServerName が変わっても対応できるようにパス形式に変えておく
    $parsed_url = parse_url($_SERVER['HTTP_REFERER']);
    $path = $parsed_url['path'];

    //遷移元ページが存在し、かつ/secure/login以外であれば、そのURLを控えておく
    if (isset($_SERVER['HTTP_REFERER']) && $path != '/secure/login') 
    {
      $ref_info = $this->_createSession();
      $ref_info->url = $_SERVER['HTTP_REFERER'];
    }

    //控えておいたURLをリダイレクト先に指定する
    $ref_info = $this->_createSession();
    $fixed_url = $ref_info->url;
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