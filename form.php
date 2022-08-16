<?php
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();

require_once('includes/config.php');
require_once('includes/functions.php');
require_once('includes/db-connect.php');

//Redirect to main page when directly loading the file.
//Prevent file execution without valid data.
if (empty($_POST['form_name'])) {
    header('Location: ' . BASE_URL);
}


$errors = array();
//clear old error massages
$_SESSION['errors'] = $errors;


//get variables from _POST
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$r_password = $_POST['r_password'];
$input_phone = $_POST['phone'];
$company_name = $_POST['company_name'];
$company_image = '';
$company_site = $_POST['company_site'];
$company_description = $_POST['company_description'];

$is_admin = false;
$valid_mail = '';
$valid_phone = '';
$valid_sait = '';
$password_hash = '';

$_SESSION['company_description'] = $company_description;
$_SESSION['company_name'] = $company_name;


//set _SESSION valid first_name
if (empty($first_name)) {
    $errors[] = "First name is required";
} else {
    $_SESSION['first_name'] = $first_name;
}

//set _SESSION valid last_name
if (empty($last_name)) {
    $errors[] = "Last name is required";
} else {
    $_SESSION['last_name'] = $last_name;
}

//set _SESSION valid email
if (!empty($email)) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is not valid";
    } else {
        $_SESSION['email'] = $email;
        $valid_mail = $email;
    }
} else {
    $errors[] = "Email is required";
}

//set _SESSION valid Phone number
$phone = extract_valid_phone($input_phone);
if (empty($phone)) {
    $errors[] = "Phone is not valid! Requested format 0891234567 or +359891234567";

    //delete previous valid record
    //required for prompt client to re-enter valid data when editing
    $_SESSION['input_phone'] = '';
} else {
    $valid_phone = $phone;
    $_SESSION['phone'] = $phone;
    $_SESSION['input_phone'] = $input_phone;
}


//set _SESSION valid site domain
if (!empty($company_site)) {
    if (!extract_valid_domaine($company_site)) {
        $errors[] = "Company site URL is not valid";
    } else {
        $valid_sait = extract_valid_domaine($company_site);
        $_SESSION['company_site'] = $valid_sait;
    }
}


//regex validating password
$reg1 = "/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*[,#?!=@%&\^\$\*\)\(\_\.\'\"\+\-])[^{}]{8,}$/";

//check
if (preg_match($reg1, $password) && strlen($password) >= 8) {
    var_dump(preg_match($reg1, $password));
    if ($password !== $r_password) {
        $errors[] = "Passwords do NOT match";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    }
} else {
    $errors[] = "Password should be at least 8 characters, at least one special character, at least one capital, and at least one small letter.";
}

//check admin privileges
if (!empty($_SESSION['email'])) {
    $split_mail = explode('@', $_SESSION['email']);
    if ($split_mail[1] == 'devrix.com') {
        $is_admin = true;
        $_SESSION['is_admin'] = true;
    }
}

//store errors in _SESSION
$_SESSION['errors'] = $errors;


//if there are errors it returns the user to enter the incorrect fields
if (!empty($errors)) {
    header('Location: ' . BASE_URL . '/register.php');
}


//write standardized data to DB
$sql = "INSERT INTO user (first_name, last_name, email, password, phone, is_admin, company_name, company_image, company_description, company_site)
VALUES ('$first_name', '$last_name', '$valid_mail','$password_hash','$valid_phone','$is_admin','$company_name','$company_image','$company_description','$valid_sait')";

$result = db_sql_run($sql);

if (!$result) {//if user with this mail exist
    //log error
    $errors[] = "A user with this mail: $valid_mail already exists";
    $_SESSION['errors'] = $errors;

    //erase exist mail
    $_SESSION['email'] = '';

    //back to register form
    header('Location: ' . BASE_URL . '/register.php');
} else {//get new user id
    $sql = "SELECT id_user FROM user where email = '$valid_mail'";
    $result = db_sql_run($sql);
    $arr_result = mysqli_fetch_assoc($result);

    //saving the user ID so that the user does not have to log in again
    $_SESSION['id_user'] = $arr_result['id_user'];

    //redirect to home page
    header('Location: ' . BASE_URL);
}

