<?php
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <?php echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/master.css">'; ?>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="site-wrapper">
    <header class="site-header">
        <div class="row site-header-inner">
            <div id="header_logo">
                <a href="/" title="logo"> <img class="site-header-branding" src="/img/logo.png" alt="logo"
                                               width="300" height="80"> </a>
            </div>
            <nav class="site-header-navigation">
                <ul class="menu">
                    <li class="menu-item current-menu-item">
                        <a href="/index.php">Home</a>
                    </li>
                    <li class="menu-item">
                        <a href="/register.php">Register</a>
                    </li>
                    <li class="menu-item">
                        <a href="/login.php">Login</a>
                    </li>
                </ul>
            </nav>
            <button class="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path fill="currentColor" class='menu-toggle-bars'
                          d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/>
                </svg>
            </button>
        </div>
    </header>
</div>
<main class="site-main">