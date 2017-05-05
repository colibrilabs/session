<?php

namespace Colibri\Session;

/**
 * Interface AdapterInterface
 * @package Colibri\Session
 */
interface AdapterInterface
{
  
  /**
   * @return $this
   */
  public function start();
  
  /**
   * @return $this
   */
  public function kill();
  
  /**
   * @param $sessionId
   * @return $this
   */
  public function setId($sessionId);
  
  /**
   * @return string
   */
  public function getId();
  
  /**
   * @param $sessionName
   * @return $this
   */
  public function setName($sessionName);
  
  /**
   * @return string
   */
  public function getName();
  
  /**
   * @return integer
   */
  public function getStatus();
  
  /**
   * @param $name
   * @return boolean
   */
  public function has($name);
  
  /**
   * @param $name
   * @param $default
   * @return string
   */
  public function get($name, $default);
  
  /**
   * @param $name
   * @param $value
   * @return $this
   */
  public function set($name, $value);
  
  /**
   * @param $name
   * @return $this
   */
  public function remove($name);
  
}