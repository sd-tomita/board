<?php
/**
 * 連続投稿回数のカウンター
 *
 * @author  Yuichiro Tomita <tomita@sunrisedigital.jp>
 * @create  2014/02/18
 * @copyright 2014 Sunrise Digital Corporation.
 * @version  v 1.01 2014/02/19 11:45
 **/

require_once 'Zend/Validate/Abstract.php';
class Bd_CheckRepeatPost extends Zend_Validate_Abstract
{
  /**
   * 連続投稿と見なす投稿間隔
   */
  const POST_INTERVAL_SECONDS = 30;
    
  /**
   * 連続投稿回数の上限値
   */
  const MAX_POST_COUNT = 5;
  
  /**
   * エラーメッセージ用の定数
   */
  const REPEAT_POST = "hoge";
  
  protected $_messageTemplates = array(
      self::REPEAT_POST => "連続投稿数が上限値になっています。30秒待ってください。"
  );
  
  public function isValid($value) 
  {
    $user = Sdx_User::getInstance();
    
    // 初回コメント投稿後
    if(!$user->getAttribute('post_limit_data'))
    {
      $user->setAttribute('post_limit_data', new stdClass());
      $data = $user->getAttribute('post_limit_data'); 
      $data->last_post_time = time();
      $data->post_count = 1;
    }
    // 2回目以降
    else
    { 
      $data = $user->getAttribute('post_limit_data'); //setAttributeは初回のみ

      // 前回投稿から POST_INTERVAL_SECONDS 以内なら
      if((time() - $data->last_post_time) <= self::POST_INTERVAL_SECONDS)
      {
        $data->post_count += 1;
        $data->last_post_time = time();
      }
      // 前回投稿から POST_INTERVAL_SECONDS を過ぎていれば
      else
      {
        $data->post_count = 1;//カウントはリセットする
        $data->last_post_time = time();//次回投稿時はこの時刻と比較
      }
    }

    // post_count数によって最終的な戻り値を決定
    if($data->post_count > self::MAX_POST_COUNT)
    {
      $this->_error(self::REPEAT_POST);
      return false;
    }
    else
    {
      return true;
    }
  }
}
