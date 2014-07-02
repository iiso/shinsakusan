<?php

require_once('config.php');
require_once('functions.php');

session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/fb_connect_php/');
}

session_destroy();

jump('index.php');
    
?>