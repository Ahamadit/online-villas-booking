<?php

/* Database credentials. Assuming you are running MySQL

server with default setting (user 'root' with no password) */

// define('DB_SERVER', 'localhost');

// define('DB_USERNAME', 'root');

// define('DB_PASSWORD', '');

// define('DB_NAME', 'u666753029_payroll');

// /*==========this connection use for live and local use same =======*\

date_default_timezone_set('Asia/Kolkata');

define('DB_SERVER', 'localhost');




///this is for local 

if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root'); 
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', ''); 
if (!defined('DB_NAME')) define('DB_NAME', 'villas'); 

// Establish database connection
$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
?>


