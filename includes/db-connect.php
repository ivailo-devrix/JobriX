<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

//open connection function  -  return connection
function open_db_conn() {
    $data_base = DB_NAME;
    $db_user_name = DB_USER;
    $db_password = DB_PASSWORD;
    $host_name = DB_HOST;


    // Create connection
    $conn = mysqli_connect($host_name, $db_user_name, $db_password, $data_base);


    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


//Preventing SQL Injection Attacks in Postgres
function db_sql_protect($sql, $params) {
    $p = '';
    foreach ($params as $param) {
        $p .= 's';
    }

    $conn = open_db_conn();

    $userStatement = mysqli_prepare($conn, $sql);

    //mysqli_stmt_bind_param($userStatement, 'iss',$id,$firstName,$lastName);
    mysqli_stmt_bind_param($userStatement, $p, ...$params);
    mysqli_stmt_execute($userStatement);
    $result = mysqli_stmt_get_result($userStatement);

    return $result;
}


//close connection function
function close_db_conn($conn) {
    mysqli_close($conn);
    return null;
}


//return sql result
function db_sql_run($sql) {
    $conn = open_db_conn();
    $result = mysqli_query($conn, $sql);

    return $result;
}

