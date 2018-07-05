<?php

session_start();
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'database_name'
    ),
    'files' => array(
        'smallFile' => 'assets/smallText.txt',
        'bigFile' => 'assets/big.txt'
    ) 
);
spl_autoload_register(function($class) {
    require_once '../class/' . $class . '.php';
});
 
?>
