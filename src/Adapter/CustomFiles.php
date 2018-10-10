<?php

namespace Subapp\Session\Adapter;

use Subapp\Session\Adapter;
use Subapp\Session\SessionException;

/**
 * Class CustomFiles
 * @package Subapp\Session\Adapter
 */
class CustomFiles extends Adapter
{
  
  /**
   * @var string
   */
  protected $sessionsDirectory;
  
  /**
   * @param array $options
   * @throws SessionException
   */
  public function __construct(array $options = [])
  {
    
    if (!isset($options['directory'])) {
      throw new SessionException('Set session directory for ' . __CLASS__);
    }
    
    $this->sessionsDirectory = $options['directory'];
    
    session_set_save_handler(
      [
        $this, 'open',
      ],
      [
        $this, 'close',
      ],
      [
        $this, 'read',
      ],
      [
        $this, 'write',
      ],
      [
        $this, 'destroy',
      ],
      [
        $this, 'gc'
      ]
    );
    
    parent::__construct($options);
  }
  
  /**
   * @param $sessionName
   * @return bool
   * @throws SessionException
   */
  public function open($sessionName)
  {
    $sessionDirectory = "{$this->sessionsDirectory}/$sessionName";
    
    if (!file_exists($sessionDirectory)) {
      if (!mkdir($sessionDirectory, 0777, true)) {
        throw new SessionException('Custom handler can`t create session directory');
      }
    }
    
    $this->setSessionsDirectory($sessionDirectory);
    
    return true;
  }
  
  /**
   * @return bool
   */
  public function close()
  {
    return true;
  }
  
  /**
   * @param $sessionId
   * @return null|string
   */
  public function read($sessionId)
  {
    $sessionFile = "{$this->getSessionsDirectory()}/$sessionId.session";
    
    return file_exists($sessionFile) ? file_get_contents($sessionFile) : null;
  }
  
  /**
   * @return mixed
   */
  public function getSessionsDirectory()
  {
    return $this->sessionsDirectory;
  }
  
  /**
   * @param mixed $sessionsDirectory
   * @return static
   * @throws SessionException
   */
  public function setSessionsDirectory($sessionsDirectory)
  {
    if (!file_exists($sessionsDirectory) || !is_dir($sessionsDirectory)) {
      throw new SessionException('Custom sessions directory not found');
    } else {
      if (!is_writable($sessionsDirectory)) {
        throw new SessionException('Custom sessions must be writable');
      }
    }
    
    $this->sessionsDirectory = $sessionsDirectory;
    
    return $this;
  }
  
  /**
   * @param $sessionId
   * @param $sessionData
   * @return bool
   */
  public function write($sessionId, $sessionData)
  {
    $sessionFile = "{$this->getSessionsDirectory()}/$sessionId.session";
    
    return file_put_contents($sessionFile, $sessionData) === false ? false : true;
  }
  
  /**
   * @param $sessionId
   * @return bool
   */
  public function destroy($sessionId)
  {
    $sessionFile = "{$this->getSessionsDirectory()}/$sessionId.session";
    
    if (file_exists($sessionFile)) {
      unlink($sessionId);
    }
    
    return true;
  }
  
  /**
   * @param $lifetime
   * @return bool
   */
  public function gc($lifetime)
  {
    foreach (glob($this->getSessionsDirectory()) as $sessionFile) {
      if (file_exists($sessionFile) && time() >= (filemtime($sessionFile) + $lifetime)) {
        unlink($sessionFile);
      }
    }
    
    return true;
  }
  
}