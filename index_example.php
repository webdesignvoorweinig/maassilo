<?php
require_once 'core/init.php';
$user = DB::getInstance()->get('users', array('username', '=',  'marc'));
$userexist = DB::getInstance()->get('users', array('username', '=',  'marc'));
// extra comment
// checken of gebruiker bestaat bij inloggen
if(!$user->count()) {
	echo 'foutieve gebruikersnaam ingegeven';
} else {
	echo 'alles in order password check kan gedaan worden';
}

// bijvoorbeeld om te checken of account bestaat
if(!$userexist->count()) {
	echo "This user does not exist, ok to register";
} else {
	echo "Please choose different username, username already taken";
}

$userinsert = DB:getinstance()->insert('users', array(
	username => 'admin',
	password => 'password',
	emailadres => 'admin@host.nl'
));