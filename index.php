<?php
if ( ! session_id() ) @ session_start();

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