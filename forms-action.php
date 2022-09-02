<?php

//Necessary file containing: The necessary custom functions, Config file constants, DB connection
require_once( dirname( __FILE__ ) . '/includes/required-includes.php' );


//redirect to home if not come from form
if ( empty( $_POST['form_name'] ) ) {
	header( 'Location: ' . BASE_URL );
	exit();
}

$form_name = $_POST['form_name'];

// call function by form name
switch ( $form_name ) {
	case 'register':
		form_action_register();
		break;

	case 'login':
		//echo "2".PHP_EOL;
		break;

	case 'apply-submission':
		form_action_apply_submission();
		break;

	case 'edit_profile':
		form_action_edit_profile();
		break;

	default:
		//if unknown form
		header( 'Location: ' . BASE_URL );
		exit();
}


function form_action_register() {
	$errors = array();

	//clear old error massages
	$_SESSION['errors'] = $errors;

	//get variables from _POST
	$first_name          = htmlspecialchars( trim( $_POST['first_name'] ) );
	$last_name           = $_POST['last_name'];
	$email               = $_POST['email'];
	$password            = $_POST['password'];
	$r_password          = $_POST['r_password'];
	$phone               = $_POST['phone'];
	$company_name        = $_POST['company_name'];
	$company_image       = '';
	$company_site        = $_POST['company_site'];
	$company_description = $_POST['company_description'];

	$is_admin      = false;
	$valid_mail    = '';
	$valid_phone   = '';
	$valid_sait    = '';
	$password_hash = '';


//logging input data to prevent re-entry if an error is logged
	$_SESSION['input_data'] = array(
		'company_description' => $company_description,
		'company_name'        => $company_name,
		'first_name'          => '',
		'last_name'           => '',
		'email'               => '',
		'phone'               => '',
		'company_site'        => '',
	);


//validate first_name
	if ( empty( $first_name ) ) {
		$errors[] = "First name is required";
	} else {
		$_SESSION['input_data']['first_name'] = $first_name;
	}


//validate last_name
	if ( empty( $last_name ) ) {
		//log error
		$errors[] = "Last name is required";
	} else {
		$_SESSION['input_data']['last_name'] = $last_name;
	}


//validate email
	if ( ! empty( $email ) ) {
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			//log error
			$errors[] = "Email is not valid";
		} else {
			$_SESSION['input_data']['email'] = $email;
			$valid_mail                      = $email;
		}
	} else {
		//log error
		$errors[] = "Email is required";
	}


//validate phone number
	if ( ! empty( $phone ) ) {
		$clean_phone = extract_valid_phone( $phone );
		if ( empty( $clean_phone ) ) {
			//log error
			$errors[] = "Phone is not valid! Requested format 0891234567 or +359891234567";
		} else {
			$_SESSION['input_data']['input_phone'] = $phone;
			$valid_phone                           = $clean_phone;
		}
	}


//validate site domain
	if ( ! empty( $company_site ) ) {
		$extract_domain = extract_valid_domaine( $company_site );
		if ( empty( $extract_domain ) ) {
			//log error
			$errors[] = "Company site URL is not valid";
		} else {
			$_SESSION['input_data']['company_site'] = $company_site;
			$valid_sait                             = $extract_domain;
		}
	}


//regex validating password
	$reg1 = "/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*[,#?!=@%&\^\$\*\)\(\_\.\'\"\+\-])[^{}]{8,}$/";

//check
	if ( preg_match( $reg1, $password ) && strlen( $password ) >= 8 ) {
		if ( $password !== $r_password ) {
			//log error
			$errors[] = "Passwords do NOT match";
		} else {
			$password_hash = password_hash( $password, PASSWORD_DEFAULT );
		}
	} else {
		//log error
		$errors[] = "Password should be at least 8 characters, at least one special character, at least one capital, and at least one small letter.";
	}


//store errors in _SESSION
	$_SESSION['errors'] = $errors;


	if ( ! empty( $errors ) ) {
		//if there are errors it returns the user to enter the incorrect fields
		header( 'Location: ' . BASE_URL . '/register.php' );
	} else {
		//write standardized data to DB
		$sql = "INSERT INTO user (first_name, last_name, email, password, phone, company_name, company_image, company_description, company_site)
    VALUES ('$first_name', '$last_name', '$valid_mail','$password_hash','$valid_phone','$company_name','$company_image','$company_description','$valid_sait')";

		$result = db_sql_run( $sql );

		if ( ! $result ) {//if user with this mail exist
			//log error
			$errors[]           = "A user with this mail: $email already exists";
			$_SESSION['errors'] = $errors;

			//erase exist mail
			$_SESSION['input_data']['email'] = '';

			//back to register form
			header( 'Location: ' . BASE_URL . '/register.php' );
		} else {
			//get new user id
			$sql        = "SELECT id_user, company_name FROM user where email = '$valid_mail'";
			$result     = db_sql_run( $sql );
			$arr_result = mysqli_fetch_assoc( $result );

			//saving the user ID so that the user does not have to log in again
			$id_user             = $arr_result['id_user'];
			$_SESSION['id_user'] = $arr_result['id_user'];
			$company_name        = $arr_result['company_name'];


			//check admin privileges
			if ( is_admin( $valid_mail ) ) {
				$_SESSION['is_admin'] = true;
			}

			//check is company
			if ( ! empty( $company_name ) ) {
				$_SESSION['is_company'] = true;
			}

			//upload logo
			if ( ! empty( $_FILES ) ) {
				$file          = $_FILES;
				$new_file_name = $arr_result['id_user'] . '.jpg';
				$result        = upload_img( $file, $new_file_name );
				foreach ( $result as $error ) {
					if ( ! empty( $error ) ) {
						$_SESSION[] = $error;
						header( 'Location: ' . BASE_URL . '/register.php' );
					}
				}

				unset( $_SESSION['input_data'] );
				unset( $_SESSION['errors'] );
				//redirect to home page
				header( 'Location: ' . BASE_URL );
			}
		}
	}
}


function form_action_edit_profile() {
	$errors = array();

	//clear old error massages
	$_SESSION['errors'] = $errors;

	//get variables from _POST
	$first_name          = htmlspecialchars( trim( $_POST['first_name'] ) );
	$last_name           = $_POST['last_name'];
	$email               = $_POST['email'];
	$password            = $_POST['password'];
	$r_password          = $_POST['r_password'];
	$phone               = $_POST['phone'];
	$company_name        = $_POST['company_name'];
	$company_image       = '';
	$company_site        = $_POST['company_site'];
	$company_description = $_POST['company_description'];

	$is_admin      = false;
	$valid_mail    = '';
	$valid_phone   = '';
	$valid_sait    = '';
	$password_hash = '';


//logging input data to prevent re-entry if an error is logged
	$_SESSION['input_data'] = array(
		'company_description' => $company_description,
		'company_name'        => $company_name,
		'first_name'          => '',
		'last_name'           => '',
		'email'               => '',
		'phone'               => '',
		'company_site'        => '',
	);


//validate first_name
	if ( empty( $first_name ) ) {
		$errors[] = "First name is required";
	} else {
		$_SESSION['input_data']['first_name'] = $first_name;
	}


//validate last_name
	if ( empty( $last_name ) ) {
		//log error
		$errors[] = "Last name is required";
	} else {
		$_SESSION['input_data']['last_name'] = $last_name;
	}


//validate email
	if ( ! empty( $email ) ) {
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			//log error
			$errors[] = "Email is not valid";
		} else {
			$_SESSION['input_data']['email'] = $email;
			$valid_mail                      = $email;
		}
	} else {
		//log error
		$errors[] = "Email is required";
	}


//validate phone number
	if ( ! empty( $phone ) ) {
		$clean_phone = extract_valid_phone( $phone );
		if ( empty( $clean_phone ) ) {
			//log error
			$errors[] = "Phone is not valid! Requested format 0891234567 or +359891234567";
		} else {
			$_SESSION['input_data']['input_phone'] = $phone;
			$valid_phone                           = $clean_phone;
		}
	}


//validate site domain
	if ( ! empty( $company_site ) ) {
		$extract_domain = extract_valid_domaine( $company_site );
		if ( empty( $extract_domain ) ) {
			//log error
			$errors[] = "Company site URL is not valid";
		} else {
			$_SESSION['input_data']['company_site'] = $company_site;
			$valid_sait                             = $extract_domain;
		}
	}


//regex validating password
	$reg1 = "/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*[,#?!=@%&\^\$\*\)\(\_\.\'\"\+\-])[^{}]{8,}$/";

//check
	if ( ! empty( $password ) && ! empty( $r_password ) ) {
		if ( preg_match( $reg1, $password ) && strlen( $password ) >= 8 ) {
			if ( $password !== $r_password ) {
				//log error
				$errors[] = "Passwords do NOT match";
			} else {
				$password_hash = password_hash( $password, PASSWORD_DEFAULT );
			}
		} else {
			//log error
			$errors[] = "Password should be at least 8 characters, at least one special character, at least one capital, and at least one small letter.";
		}

	}
//store errors in _SESSION
	$_SESSION['errors'] = $errors;


	if ( ! empty( $errors ) ) {
		//if there are errors it returns the user to enter the incorrect fields
		header( 'Location: ' . BASE_URL . '/profile.php' );
	} else {

		$id_user = $_SESSION['id_user'];

		if ( empty( $password_hash ) ) {
			$sql = "UPDATE `user` SET `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$valid_mail', `phone` = '$valid_phone', `company_name` = '$company_name', `company_site` = '$valid_sait' , `company_description` = '$company_description' WHERE `user`.`id_user` = $id_user";
		} else {
			$sql = "UPDATE `user` SET `first_name` = '$first_name', `last_name` = '$last_name', `password` = '$password_hash', `email` = '$valid_mail', `phone` = '$valid_phone', `company_name` = '$company_name', `company_site` = '$valid_sait' , `company_description` = '$company_description' WHERE `user`.`id_user` = $id_user";
		}

		$result = db_sql_run( $sql );

		if ( ! $result ) {//if user with this mail exist
			//log error
			$errors[]           = "Error";
			$_SESSION['errors'] = $errors;

			//back to register form
			echo 'error submit';
			header( 'Location: ' . BASE_URL . '/profile.php' );
		} else {

			//check admin privileges
			if ( is_admin( $valid_mail ) ) {
				$_SESSION['is_admin'] = true;
			} else {
				if ( ! empty( $_SESSION['is_admin'] ) ) {
					unset( $_SESSION['is_admin'] );
				}
			}

			//check is company
			if ( ! empty( $company_name ) ) {
				$_SESSION['is_company'] = true;
			} else {
				if ( ! empty( $_SESSION['is_company'] ) ) {
					unset( $_SESSION['is_company'] );
				}
			}

			//upload logo
			if ( ! empty( $_FILES ) ) {
				$file          = $_FILES;
				$new_file_name = $_SESSION['id_user'] . '.jpg';
				$result        = upload_img( $file, $new_file_name );
				foreach ( $result as $error ) {
					if ( ! empty( $error ) ) {
						$_SESSION[] = $error;
						header( 'Location: ' . BASE_URL . '/profile.php' );
					}
				}

				unset( $_SESSION['input_data'] );
				unset( $_SESSION['errors'] );
				unset( $_FILES );

				//redirect to home page
				header( 'Location: ' . BASE_URL . '/profile.php' );
			}
		}
	}
}

function form_action_apply_submission() {

	//get variables from _POST
	$first_name  = htmlspecialchars( trim( $_POST['first_name'] ) );
	$last_name   = $_POST['last_name'];
	$email       = $_POST['email'];
	$job_id      = $_POST['job-id'];
	$phone       = $_POST['phone'];
	$message     = $_POST['message'];
	$id_user     = $_SESSION['id_user'];
	$target_file = '';


	if ( ! empty( $_FILES ) ) {
		$cv_name        = $_FILES['fileToUpload']['name'];
		$cv_tmp_name    = $_FILES['fileToUpload']['tmp_name'];
		$cv_upload_path = './docs/' . $cv_name;
		$db_path        = 'docs/' . $cv_name;
		move_uploaded_file( $cv_tmp_name, $cv_upload_path );
	}

	$sql = "INSERT INTO submissions (id_job, id_user, first_name, last_name, email, custom_message, phone, doc_upload) 
						VALUES ('$job_id','$id_user','$first_name','$last_name', '$email', '$message','$phone','$db_path')";

	$result = db_sql_run( $sql );

	if ( ! $result ) {//if user with this mail exist
		//log error
		$errors[]           = "Error";
		$_SESSION['errors'] = $errors;

		//back to register form
		echo 'error submit';
		//header( 'Location: ' . BASE_URL . '/profile.php' );
	} else { ?>
		<?php require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' );


		?>

        <section class="section-fullwidth">
            <div class="row">
                <div class="flex-container centered-vertically centered-horizontally">
                    <div class="form-box box-shadow">
                        <div class="section-heading">
                            <h2 class="heading-title" style="color: #3c71fe">The application has been sent
                                successfully.</h2>
                            <h2 class="heading-title" style="color: green">Congratulations!</h2>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
		<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
	<?php }


}