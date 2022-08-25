<?php
session_start();

require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php' ); //required in first position to load constants for subsequent includes
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php' );
