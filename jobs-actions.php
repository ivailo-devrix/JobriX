<?php
require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//Redirect to homepage if id missing or no admin privileges.
if ( empty( $_SESSION['user_id'] ) || ! ( $_SESSION['is_admin'] ) ) {
	header( 'Location: ' . BASE_URL );
	exit();
}

//Redirect to homepage if missing params.
if ( empty( $_GET['id'] ) || empty( $_GET['action'] ) || ! is_numeric( $_GET['id'] ) ) {
	header( 'Location: ' . BASE_URL );
	exit();
}


$id     = mysqli_real_escape_string( open_db_conn(), $_GET['id'] );
$action = $_GET['action'];

switch ( $action ) {
	case 'approve':
		$sql    = "UPDATE jobs SET jobs.status = 'active' WHERE id_jobs = ?";
		$params = array( $id );
		break;

	case 'reject':
		$sql    = "UPDATE jobs SET jobs.status = 'reject' WHERE id_jobs = ?";
		$params = array( $id );
		break;

	default:
		header( 'Location: ' . BASE_URL );
		exit();
}


//if everything above is fulfilled and all data is validated, the request will be fulfilled.
db_sql_protect( $sql, $params );
header( 'Location: ' . BASE_URL . '/dashboard.php' );