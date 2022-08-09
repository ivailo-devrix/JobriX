<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');


$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}else{
    echo 'connect!';
}