<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

session_unset();
session_destroy();

setcookie( 'validator', '', '' );
setcookie( 'user_id', '', '' );

header( 'Location: ' . BASE_URL );
