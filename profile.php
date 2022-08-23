<?php
require_once (dirname(__FILE__).'/includes/required-includes.php'); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "My Profile | Jobrix.tk";
$page_name = 'profile';

//header template include
require_once (dirname(__FILE__).'/includes/theme-compat/header.php');
require_once (dirname(__FILE__).'/includes/theme-compat/register-profile.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php');
