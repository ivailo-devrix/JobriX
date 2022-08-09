<?php

// getting the real domain where the site is hosted
$domain = $_SERVER['SERVER_NAME'];


// getting HTTPS parameter if SSL is turned on
if (SSL_ENABLED){
    $httpParam = "https://";
}else{
    $httpParam = "http://";
}

$HTTP_DOMAIN = $httpParam.$domain ;