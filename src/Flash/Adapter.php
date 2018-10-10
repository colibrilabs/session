<?php

namespace Subapp\Session\Flash;

/**
 * Class Adapter
 * @package Dez\Flash
 */
abstract class Adapter
{
  
  /**
   * @param $message
   * @return $this
   */
  public function info($message)
  {
    $this->message('info', $message);
    
    return $this;
  }
  
  /**
   * @param $message
   * @return $this
   */
  public function success($message)
  {
    $this->message('success', $message);
    
    return $this;
  }
  
  /**
   * @param $message
   * @return $this
   */
  public function notice($message)
  {
    $this->message('notice', $message);
    
    return $this;
  }
  
  /**
   * @param $message
   * @return $this
   */
  public function warning($message)
  {
    $this->message('warning', $message);
    
    return $this;
  }
  
  /**
   * @param $message
   * @return $this
   */
  public function error($message)
  {
    $this->message('error', $message);
    
    return $this;
  }
  
  /**
   * @return string
   */
  public function getUniqueKey()
  {
    return 'flash_' . md5(__FILE__);
  }
  
  /**
   * @param null $type
   * @return array
   */
  abstract public function getMessages($type = null);
  
  /**
   * @param $type
   * @return bool
   */
  abstract public function hasMessages($type);
  
  /**
   * @param $type
   * @param $message
   * @return $this
   */
  abstract public function message($type, $message);
  
  /**
   * @param $type
   * @return $this
   */
  abstract public function clear($type);
  
}