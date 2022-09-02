<?php require_once dirname( __FILE__ ) . '/includes/required-includes.php'; // Necessary  containing: The necessary custom functions, Config file constants, DB connection.

// params for include template.
$meta_title = 'Login page | Jobrix.tk';
$page_name  = 'login';

// header template include.
require_once dirname( __FILE__ ) . '/includes/theme-compat/header.php';


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
	$sql    = 'SELECT * FROM user WHERE email = ?';
	$params = [ $email ];
	$result = db_sql_protect( $sql, $params );

	if ( mysqli_num_rows( $result ) > 0 ) {
		$result = mysqli_fetch_assoc( $result );

		$db_password  = $result['password'];
		$user_id      = $result['id_user'];
		$company_name = $result['company_name'];

		if ( password_verify( $password, $db_password ) ) {
			$correct_password = true;

			$_SESSION['id_user'] = $user_id;

			if ( is_admin( $email ) ) {
				$_SESSION['is_admin'] = true;
			}

			if ( ! empty( $company_name ) ) {
				$_SESSION['is_company'] = true;
			}

			if ( ! empty( $_POST['remember'] ) ) {
				$validator_date = time() + 60 * 60 * 24 * REMEMBER_ME_DAYS;
				$validator      = bin2hex( random_bytes( 32 ) );

				$sql = "UPDATE `user` SET `validator` = '" . $validator . "', `validator_date` = '" . $validator_date . "' WHERE `user`.`id_user` = " . $user_id . ';';

				setcookie( "validator", $validator, $validator_date );
				setcookie( "user_id", $user_id, $validator_date );
			} else {
				$sql = "UPDATE `user` SET `validator` = '', `validator_date` = '' WHERE `user`.`id_user` = " . $user_id . ";";

				setcookie( 'validator', '', '' );
				setcookie( 'user_id', '', '' );
			}
			$conn   = open_db_conn();
			$result = mysqli_query( $conn, $sql );

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
                            <p class="error" style="color: red;"><?php echo "Wrong password or Email"; ?></p>
						<?php }
					} ?>
                    <p><input type="checkbox" name="remember"/> Remember me </p>
                    <button type="submit" class="button">
                        Login
                    </button>
                </form>
                <a href="#" class="button button-inline">Forgot Password</a>
            </div>
        </div>
    </div>
</section>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php';


?>
