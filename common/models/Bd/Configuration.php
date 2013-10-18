<?php
/**
 *
 *
 * @author  Masamoto Miyata <miyata@able.ocn.ne.jp>
 * @create  2011/10/03
 * @copyright 2011 Sunrise Digital Corporation.
 * @version  v 1.0 2011/10/03 18:40 Miyata
 **/
abstract class Bd_Configuration extends Sdx_Configuration
{
  protected function _init(Sdx_Context $context)
  {
    //Helperのオートロードは後にセットされたprefixから優先的に検索されます。
    //Sdxの追加は本来Sdx側でするべきですが既存のコードへの影響を考えここでやります。
    Zend_Controller_Action_HelperBroker::addPrefix('Sdx_Controller_Action_Helper');
    Zend_Controller_Action_HelperBroker::addPrefix('Bd_Controller_Action_Helper');
  }
  
  protected function _initHttp(Sdx_Context $context)
  {
    $this->_addHelper(new Sdx_Controller_Action_Helper_UriNormalizer());
  }
}

class Configuration extends Bd_Configuration
{  
  protected function _initHttp(Sdx_Context $context)
  {
    parent::_initHttp($context);
 
    //If you want to register other auto load namespase, Remove this comment out.
    //$context->registerAutoloadNamespace('Other');
 
    $context->registerControllerPlugin(new Sdx_Controller_Plugin_AccessControl());
    $context->registerControllerPlugin(new Bd_Controller_Plugin_AutoLogin('.board.sunrisedigital.jp'));
  }
}
