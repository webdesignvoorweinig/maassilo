<?php
session_start();

$GLOBALS['config'] =  array (
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'webdesignvoorweinig',
		'password' => 'MM3ij3r1982',
		'db' => 'maassilo' 
			
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
		
	),
	'session'  => array(
		'session_name' => 'user'
	)
);

spl_autoload_register(function($class) {
	require_once 'classes/'. $class . '.php';
});

require_once 'functions/sanitize.php';
require_once 'functions/output.php';	