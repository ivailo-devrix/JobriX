<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

//open connection function  -  return connection
function open_db_conn()
{
    $data_base = DB_NAME ;
    $db_user_name = DB_USER;
    $db_password = DB_PASSWORD;
    $host_name = DB_HOST ;

    // Create connection
    $conn = mysqli_connect($host_name, $db_user_name, $db_password, $data_base);


    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


//close connection function
function close_db_conn($conn){
    mysqli_close($conn);
    return null;
}


//return sql result
function db_sql_run($sql){
    $conn = open_db_conn();

    $result = mysqli_query($conn, $sql);

    close_db_conn($conn);
    return $result;
}

