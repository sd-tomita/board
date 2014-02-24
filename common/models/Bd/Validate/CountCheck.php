<?php
/**
 * カウントが規定値を超えていないかの検証
 *
 * @author  Yuichiro Tomita <tomita@sunrisedigital.jp>
 * @create  2014/02/18
 * @copyright 2014 Sunrise Digital Corporation.
 * @version  v 1.02 2014/02/20 12:45
 **/

require_once 'Zend/Validate/Abstract.php';
class Bd_Validate_CountCheck extends Zend_Validate_Abstract
{
  const MAX_COUNT_OVER = "hoge";
  
  protected $_messageTemplates = array(
    self::MAX_COUNT_OVER => "回数オーバーです"
  );
  
  private $count_data;
  private $max_count;
  
  public function __construct($curent, $maximum, $message = null) 
  {
    $this->count_data = $curent;
    $this->max_count = $maximum;
    if(isset($message))
    {
      $this->_messageTemplates[self::MAX_COUNT_OVER] = $message;
    }
  }
  
  public function isValid($value)
  {
    if($this->count_data >= $this->max_count)
    {
      $this->_error(self::MAX_COUNT_OVER);
      return false;
    }
    else
    {
      return true;
    }
  }
}
