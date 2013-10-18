<?php
class Bd_Controller_Plugin_AutoLogin extends Sdx_Controller_Plugin_AutoLogin
{
  /**
  *
  * @return Zend_Auth_Adapter_Interface
  * @param string $cookie
  */
  protected function _getAutoLoginAdapter($token)
  {
    return new Bd_Auth_Adapter_DbAutoLogin($token);
  }
  
  //サーバー側のトークン削除
  protected function _cleanUpOldToken($token) {
      $t_al = Bd_Orm_Main_AutoLogin::getTable();
      $db = $t_al->updateConnection();
      $db->beginTransaction();
      try
      {
        $db->delete($t_al->getTableName(), $db->quoteInto('hash = ?', $token));
        $db->commit();
      }
      catch (Exception $e)
      {
        $db->rollback();
        throw $e;
      }
  }
 
  /**
   * $tokenとアカウントを関連付けて保存します。
   * @param Sdx_User $user
   * @param string $token
   */
  protected function _saveAutoLoginId(Sdx_User $user, $token)
  {
    $record = Bd_Orm_Main_Account::getTable()->findByColumn('login_id', $user->getLoginId());
    
    if($record instanceof Sdx_Null)
    {
        throw new Sdx_Exception('Not exists login id is' .$user->getLoginId());
    }
    $today = new Zend_Date();
    
    $al = new Bd_Orm_Main_AutoLogin();
    $al
            ->setHash($token)
            ->setAccountId($record->getId())
            ->setExpireDate($today->addSecond($this->_cookie_expire)->toString("yyyy-MM-dd HH:mm:ss"));
    $al->beginTransaction();
    try 
    {
       $al->save();
       $al->commit();
    }
    catch (Exception $e)
    {
        $al->rollback();
        throw $e;
    }
  }
}