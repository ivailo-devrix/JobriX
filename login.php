<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Login page | Jobrix.tk";
$page_name  = 'login';

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' );

if ( ! empty( $_SESSION['id_user'] ) ) {
	header( 'Location: ' . BASE_URL );
}

if ( ! empty( $_POST['email'] ) && ! empty( $_POST['password'] ) ) {

	if ( empty( $_SESSION['id_user'] ) ) {
		$correct_password = false;
	} else {
		header( 'Location: ' . BASE_URL );
	}

	$email    = $_POST['email'];
	$password = $_POST['password'];

	//Preventing SQL Injection Attacks in Postgres
	$sql    = "SELECT * FROM user WHERE email = ?";
	$params = [ $email ];
	$result = db_sql_protect( $sql, $params );

	if ( mysqli_num_rows( $result ) > 0 ) {
		$result = mysqli_fetch_assoc( $result );

		$db_password = $result['password'];

		if ( password_verify( $password, $db_password ) ) {
			$correct_password    = true;
			$_SESSION['id_user'] = $result['id_user'];
			header( 'Location: ' . BASE_URL );
		}
	}
} ?>
    <section class="section-fullwidth section-login">
        <div class="row">
            <div class="flex-container centered-vertically centered-horizontally">
                <div class="form-box box-shadow">
                    <div class="section-heading">
                        <h2 class="heading-title">Login</h2>
                    </div>
                    <form method="post">
                        <div class="form-field-wrapper">
                            <input type="email" name="email" autocomplete="username" placeholder="Email"/>
                        </div>
                        <div class="form-field-wrapper">
                            <input type="password" name="password" autocomplete="current-password"
                                   placeholder="Password"/>
                        </div>
						<?php if ( isset( $password ) ) {
							if ( ! $correct_password ) { ?>
                                <p class="error"><?php echo "Wrong password or Email"; ?></p>

							<?php }
						} ?>
                        <button type="submit" class="button">
                            Login
                        </button>
                    </form>
                    <a href="#" class="button button-inline">Forgot Password</a>
                </div>
            </div>
        </div>
    </section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
