<?php
require_once('includes/config.php');
require_once('includes/functions.php');
require_once('includes/db-connect.php');


$valid_mail = 'test@devrix.com';

$sql = "SELECT id_user FROM user where email = '$valid_mail'";
$result = db_sql_run($sql);

$arr_result = mysqli_fetch_assoc($result);


var_dump($arr_result);