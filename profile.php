<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "My Profile | Jobrix.tk";
$page_name  = "profile";

//kicking the user if not logged in
kick_if_not_logged_in();

if ( empty( $_SESSION['id_user'] ) ) {
	header( 'Location: ' . BASE_URL );
	exit();
}

$id_user = intval( $_SESSION['id_user'] );

$sql    = "SELECT * FROM user WHERE id_user = $id_user";
$result = db_sql_run( $sql );
$user   = mysqli_fetch_assoc( $result );

$_SESSION['input_data'] = array(
	'company_description' => '',
	'company_name'        => '',
	'first_name'          => '',
	'last_name'           => '',
	'email'               => '',
	'phone'               => '',
	'company_site'        => '',
);

foreach ( $user as $key => $value ) {
	if ( ! empty( $value ) && array_key_exists( $key, $_SESSION['input_data'] ) ) {
		$_SESSION['input_data'][ $key ] = $value;
	}
}

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' );
//form template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/register-profile.php' );

unset( $_SESSION['input_data'] );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' );
