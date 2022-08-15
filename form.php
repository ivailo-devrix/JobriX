<?php
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();

require_once('includes/config.php');
require_once('includes/functions.php');


//Redirect to main page when directly loading the file.
//Prevent file execution without valid data.
if (empty($_POST['form_name'])) {
    header('Location: ' . BASE_URL);
}


$errors = [];
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
$company_site = $_POST['company_site'];
$company_description = $_POST['company_description'];

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
    }
} else {
    $errors[] = "Email is required";
}

//set _SESSION valid Phone number
$phone = extract_valid_phone($input_phone);
if (empty($valid_phone)) {
    $errors[] = "Phone is not valid! Requested format 0891234567 or +359891234567";

    //delete previous valid record
    //required for prompt client to re-enter valid data when editing
    $_SESSION['input_phone'] = '';
} else {
    $_SESSION['phone'] = $phone;
    $_SESSION['input_phone'] = $input_phone;
}


//set _SESSION valid Phone number
if (!empty($company_site)) {
    if (!extract_valid_domaine($company_site)) {
        $errors[] = "Company site URL is not valid";
    } else {
        $_SESSION['company_site'] = extract_valid_domaine($company_site);
    }
}

//validate password
$reg1 = "/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*[,#?!=@%&\^\$\*\)\(\_\.\'\"\+\-])[^{}]{8,}$/";


if (preg_match($reg1, $password) && strlen($password) >= 8) {
    var_dump(preg_match($reg1, $password));
    if ($password !== $r_password) {
        $errors[] = "Passwords do NOT match";
    }
} else {
    $errors[] = "Password should be at least 8 characters, at least one special character, at least one capital, and at least one small letter.";
}


$_SESSION['errors'] = $errors;

if (!empty($errors)) {
    header('Location: ' . BASE_URL . '/register.php');
}



//    <form action="/form.php" id="register" method="post" enctype="multipart/form-data">
//                        <div class="flex-container justified-horizontally">
//                            <div class="primary-container">
//                                <h4 class="form-title">About me</h4>
//                                <div class="form-field-wrapper">
//                                    <input type="text" name="first_name" placeholder="First Name*" required>
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <input type="text" name="last_name" placeholder="Last Name*" required>
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <input type="email" name="email" placeholder="Email*" required>
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <input type="password" name="password" placeholder="Password*" required>
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <input type="password" name="r_password" placeholder="Repeat Password*" required>
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <input type="text" name="phone" placeholder="Phone Number">
//                                </div>
//                            </div>
//                            <div class="secondary-container">
//                                <h4 class="form-title">My Company</h4>
//                                <div class="form-field-wrapper">
//                                    <input type="text" name="company_name" placeholder="Company Name">
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <input type="text" name="company_site" placeholder="Company Site">
//                                </div>
//                                <div class="form-field-wrapper">
//                                    <textarea placeholder="Description"></textarea>