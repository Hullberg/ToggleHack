<?php
if ( ! session_id() ) @ session_start();
// Initiate the toggle-buttons.
if (!isset($_SESSION['sql'])) {
    $_SESSION['sql'] = 'OFF';
}
if (!isset($_SESSION['xss'])) {
    $_SESSION['xss'] = 'OFF';
}
if (!isset($_SESSION['cookies'])) {
    $_SESSION['cookies'] = 'OFF';
}


require_once('connection.php');

// http://php.net/manual/en/reserved.variables.get.php

if (isset($_GET['controller']) && isset($_GET['action'])) {
	$controller = $_GET['controller'];
	$action     = $_GET['action'];
} else {
	$controller = 'pages';
	$action     = 'home';
}

require_once('views/layout.php');
?>