<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Include the root config file. The APPPATH constant ends with a slash.
require_once(APPPATH . '../config.php');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PASSWORD,
    'database' => DB_NAME,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE, // Set to TRUE for development
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => DB_CHARSET,
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
