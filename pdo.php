<?php

// config
$dbhost    = 'localhost';
$dbname    = 'DATABASE_NAME';
$dbuser    = 'USERNAME';
$dbpasswd  = 'PASSWORD';
$dbcharset = 'utf8';

try {

    $db = new PDO("mysql:host={$dbhost};dbname={$dbname};charset={$dbcharset}", $dbuser, $dbpasswd, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$dbcharset}'"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

catch(Exception $e) {
    error_log('Connection failed: ' . $e->getMessage());
}