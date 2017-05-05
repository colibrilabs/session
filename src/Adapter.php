<?php

namespace Colibri\Session;

/**
 * Class Adapter
 * @package Colibri\Session
 */
abstract class Adapter implements AdapterInterface
{
  
  protected $dependencyInjection;
  
  public function __construct(array $options = [])
  {
    
  }
  
  /**
   * @return $this
   */
  public function start()
  {
    session_start();
    
    return $this;
  }
  
  /**
   * @return $this
   */
  public function kill()
  {
    session_destroy();
    
    return $this;
  }
  
  /**
   * @param $sessionId
   * @return $this
   */
  public function setId($sessionId)
  {
    session_id($sessionId);
    
    return $this;
  }
  
  /**
   * @return string
   */
  public function getId()
  {
    return session_id();
  }
  
  /**
   * @param $sessionName
   * @return $this
   */
  public function setName($sessionName)
  {
    session_name($sessionName);
    
    return $this;
  }
  
  /**
   * @return string
   */
  public function getName()
  {
    return session_name();
  }
  
  /**
   * @return integer
   */
  public function getStatus()
  {
    return session_status();
  }
  
  /**
   * @param $name
   * @param $value
   * @return $this
   */
  public function push($name, $value)
  {
    $data = $this->get($name, []);
    $data = !is_array($data) ? [$data] : $data;
    $data[] = $value;
    $this->set($name, $data);
    
    return $this;
  }
  
  /**
   * @param $name
   * @param $default
   * @return string
   */
  public function get($name = null, $default = null)
  {
    return $name !== null ? ($this->has($name) ? $_SESSION[$name] : $default) : $_SESSION;
  }
  
  /**
   * @param $name
   * @return boolean
   */
  public function has($name)
  {
    return isset($_SESSION[$name]);
  }
  
  /**
   * @param $name
   * @param $value
   * @return $this
   */
  public function set($name, $value)
  {
    $_SESSION[$name] = $value;
    
    return $this;
  }
  
  /**
   * @param $name
   * @return $this
   */
  public function remove($name)
  {
    if ($this->has($name)) {
      unset($_SESSION[$name]);
    }
    
    return $this;
  }
  
}