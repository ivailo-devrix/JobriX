<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Registration Forms | Jobrix.tk";
$page_name  = "register";

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' );

//register-profile.php template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/register-profile.php' );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' );
