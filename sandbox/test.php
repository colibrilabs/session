<?php

namespace Sandbox;

use Subapp\Session\Adapter\Files as NativeSession;

error_reporting(1);
ini_set('display_errors', 1);

include_once '../vendor/autoload.php';

try {
  
  $session = new NativeSession();
  
  $session->setName('dez-session');
  $session->setId('dez-session-' . sha1(__FILE__));
  
  $session->start();
  
  $session->set('test', ['123123']);
  
  $session->push('test', rand(1, 10000));
  $session->push('test', rand(1, 10000));
  
  var_dump($session->get('test'), $_SESSION);
  
} catch (\Exception $e) {
  die(get_class($e) . ': ' . $e->getMessage());
}