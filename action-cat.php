<?php
require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//Redirect to homepage if id missing or no admin privileges.
if ( empty( $_SESSION['user_id'] ) || ! ( $_SESSION['is_admin'] ) ) {
	header( 'Location: ' . BASE_URL );
	exit();
}

//Redirect to homepage if missing params.
if ( empty( $_GET['action'] ) ) {
	header( 'Location: ' . BASE_URL );
	exit();
}


$action            = $_GET['action'];
$_SESSION['error'] = '';
$_SESSION['input'] = '';

switch ( $action ) {
	case 'new':
		if ( empty( $_GET['cat-name'] ) ) { //Redirect to homepage if missing params.
			header( 'Location: ' . BASE_URL );
			exit();
		}

		//data preparation
		$cat_name = trim( $_GET['cat-name'] );
		$cat_name = mysqli_real_escape_string( open_db_conn(), $cat_name );
		$params   = array( $cat_name );

		//check if cat exist
		$sql    = "SELECT * FROM category WHERE name = ?";
		$result = db_sql_protect( $sql, $params );
		if ( mysqli_num_rows( $result ) > 0 ) {
			$_SESSION['error'] = 'Category already exists!';
			$_SESSION['input'] = $cat_name;
			header( 'Location: ' . BASE_URL . '/category-dashboard.php' );
			exit();
		}

		//if everything above is fulfilled and all data is validated, the request will be fulfilled.
		$sql = "INSERT INTO category (name) VALUES (?)";
		db_sql_protect( $sql, $params );
		//return user to category-dashboard.php
		header( 'Location: ' . BASE_URL . '/category-dashboard.php' );
		exit();

	case 'delete':
		$id     = mysqli_real_escape_string( open_db_conn(), $_GET['id'] );
		$sql    = "SELECT * FROM category_job WHERE id_category = ?";
		$params = array( $id );
		$result = db_sql_protect( $sql, $params );
		if ( mysqli_num_rows( $result ) > 0 ) {
			$_SESSION['error'] = 'There are added ads in category. Category must be empty to delete it!';
			header( 'Location: ' . BASE_URL . '/category-dashboard.php' );
			exit();
		}

		$sql = "DELETE FROM category WHERE id_category = ?";
		db_sql_protect( $sql, $params );
		header( 'Location: ' . BASE_URL . '/category-dashboard.php' );
		exit();

	default:
		header( 'Location: ' . BASE_URL );
		exit();
}
