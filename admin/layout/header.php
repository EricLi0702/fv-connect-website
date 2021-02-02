<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="admin dashboard, FileVine Connect">
    <meta name="description" content="FileVine Connect">
    <meta name="robots" content="noindex,nofollow">
    <title>FileVine Connect Admin Panel</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <!-- Custom CSS -->
    <link href="../assets/plugins/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<!-- Preloader - style you can find in spinners.css -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<!-- Main wrapper - style you can find in pages.scss -->
<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

    <!-- Topbar header - style you can find in pages.scss -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin6">
                <!-- Logo -->
                <a class="navbar-brand justify-content-center" href="index.php">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <?php
                            $logo_img = get_logo();
                            $logo_path = "../" . $logo_img;
                            
                            If(file_exists($logo_path)) {
                       ?>
                            <img src="<?php echo $logo_path;?>" style="width:100%;" alt="homepage" class="dark-logo" />
                        <?php } else { ?>
                            <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                        <?php } ?>
                    </b>
                    
                    <!-- Logo text -->
                    <span class="logo-text">
                        <!-- dark Logo text -->
                        <!--<img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />-->
                    </span>
                </a>
                
                <!-- toggle and nav items -->
                <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            </div>

            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <ul class="navbar-nav d-none d-md-block d-lg-none">
                    <li class="nav-item">
                        <a class="nav-toggler nav-link waves-effect waves-light text-white"
                            href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    </li>
                </ul>
                
                <!-- toggle and nav items -->
                <ul class="navbar-nav mr-auto mt-md-0 ">
                    <li class="nav-item hidden-sm-down">
                        <form class="app-search pl-3">
                            <input type="text" class="form-control" placeholder="Search for..."> <a class="srh-btn"><i class="ti-search"></i></a>
                        </form>
                    </li>
                </ul>

                <!-- Right side toggle and nav items -->
                <ul class="navbar-nav">
                    <!-- User profile and search -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="pages-profile.php" 
                            aria-haspopup="true" aria-expanded="false"><?php if(isset($_SESSION["Full_name"])){ echo $_SESSION["Full_name"];} ?></a>
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="<?php echo ROOTURL . 'admin/logout.php'?>">Log Out</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>