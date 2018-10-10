<?php

namespace Subapp\Session\Flash\Flash;

use Subapp\Session\Adapter as SessionAdapter;
use Subapp\Session\Flash\Adapter;

/**
 * Class Session
 * @package Subapp\Session\Flash\Adapter
 */
class Session extends Adapter
{
  
  /**
   * @var SessionAdapter
   */
  private $session;
  
  /**
   * Session constructor.
   * @param SessionAdapter $session
   */
  public function __construct(SessionAdapter $session)
  {
    $this->session = $session;
  }
  
  /**
   * @param $type
   * @return bool
   */
  public function hasMessages($type)
  {
    $messages = $this->session->get($this->getUniqueKey(), []);
    
    return isset($messages[$type]);
  }
  
  
  /**
   * @param null $type
   * @return array
   */
  public function getMessages($type = null)
  {
    if ($type == null) {
      $messages = $this->session->get($this->getUniqueKey(), []);
    } else {
      $messages = $this->hasMessages($type) ? $this->session->get($this->getUniqueKey(), [])[$type] : [];
    }
    
    $this->clear($type);
    
    return $messages;
  }
  
  /**
   * @param $type
   * @param $message
   * @return $this
   */
  public function message($type, $message)
  {
    $messages = $this->session->get($this->getUniqueKey(), []);
    $messages[$type][] = $message;
    $this->session->set($this->getUniqueKey(), $messages);
    
    return $this;
  }
  
  /**
   * @param null $type
   * @return $this
   */
  public function clear($type = null)
  {
    if ($type === null) {
      $this->session->set($this->getUniqueKey(), []);
    } else {
      $messages = $this->session->get($this->getUniqueKey(), []);
      $messages[$type] = [];
      $this->session->set($this->getUniqueKey(), $messages);
    }
    
    return $this;
  }
  
}
