<?php
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php'); //required in first position to load constants for subsequent includes
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');