<?php
/**
 * データベースを使うログインに使用します。使わない場合はSdx_Auth_Adapterを継承して下さい。
 **/
class Bd_Auth_Adapter_Db extends Sdx_Auth_Adapter_Db2
{
  /**
   * 入力されたログインID
   * @var string
   */
  private $_login_id;

  /**
   * 生パスワード
   * @var string
   */
  private $_password;

  /**
   * コンストラクタ
   * @param string $login_id 入力されたログインID
   * @param string $password 生パスワード
   */
  public function __construct($login_id, $password)
  {
    $this->_login_id = $login_id;
    $this->_password = $password;
  } 

  /**
   * アカウントのデータを検索して返す
   * この段階ではまだパスワードチェックはしません。
   * @return boolean|mixed
   */
  protected function _find()
  {
    $t_account = Bd_Orm_Main_Account::getTable();
    $account = $t_account->findByColumn('login_id', $this->_login_id, $this->getDb());
    if (!$account instanceof Bd_Orm_Main_Account)
    {
      //アカウントが見つからなかったが、
      //サイドチャネル攻撃対策として同程度の時間掛けるためにパスワード計算処理を行う
      Bd_Orm_Main_Account::hashPassword('timing attack guard');
      return false;
    }
 
    return $account;
  }

  /**
   * パスワードが一致しているか検証する
   * @param mixed $account
   * @return bool|array セッションの保持されてSdx_Userから取得可能になります。例：array('login_id'=>'xxxx', 'role'=>'xxx')
   */
  protected function _auth($account)
  {
    if (Bd_Orm_Main_Account::hashPassword($this->_password) != $account->getPassword())
    {
      //パスワードが一致しない
      return false;
    }
 
    return array(
      'login_id' => $account->getLoginId(),
    );
  }

}