<?php
//Checking for variables coming from a previous scope where the given template was loaded
if (empty($meta_title)) {
    $meta_title = '';
}
if (empty($page_name)) {
    $page_name = '';
}

var_dump($_SESSION);

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
                    <li class="menu-item <?php if(isset($page_name) && $page_name == 'home'){ ?> current-menu-item <?php } ?>">
                        <a href="/index.php">Home</a>
                    </li>
                    <?php if(isset($_SESSION['id_user'])){?>
                        <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){?>
                    <li class="menu-item <?php if(isset($page_name) && $page_name == 'dashboard'){ ?> current-menu-item <?php } ?> ">
                        <a href="/dashboard.php">Dashboard</a>
                    </li>
                        <?php } ?>
                    <li class="menu-item <?php if(isset($page_name) && $page_name == 'profile'){ ?> current-menu-item <?php } ?>">
                        <a href="/profile.php">My Profile</a>
                    </li>
                    <li class="menu-item">
                        <a href="/signout.php">Sign Out</a>
                    </li>
                    <?php } ?>
                    <?php if(empty($_SESSION['id_user'])){ ?>
                    <li class="menu-item <?php if(isset($page_name) && $page_name == 'register'){ ?> current-menu-item <?php } ?>">
                        <a href="/register.php">Register</a>
                    </li>
                    <li class="menu-item <?php if(isset($page_name) && $page_name == 'login'){ ?> current-menu-item <?php } ?> ">
                        <a href="/login.php">Login</a>
                    </li>
                    <?php } ?>
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