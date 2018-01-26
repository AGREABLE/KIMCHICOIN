<!DOCTYPE html>
<html lang="en-us">
<head>

    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="no-referrer" />

    <title><?php echo $ci->config->item('service_name')?></title>

    <meta name="author" content="<?php echo $ci->config->item('service_name')?>">
    <meta name="description" content="<?php echo $ci->config->item('service_name')?>">


    <!-- Stylesheets
    ============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/canvas/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/assets/canvas/style.css" type="text/css" />
    <link rel="stylesheet" href="/assets/canvas/css/dark.css" type="text/css" />
    <link rel="stylesheet" href="/assets/canvas/css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/assets/canvas/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="/assets/canvas/css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="/assets/canvas/css/responsive.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="/assets/canvas/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/canvas/js/plugins.js"></script>

    <script type="text/javascript" src="/assets/js/default.js"></script>

    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <link rel="stylesheet" href="/assets/css/canvas.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/default.css" type="text/css" />

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Header
    ============================================= -->
    <header id="header" class="transparent-header full-header" data-sticky-class="not-dark">

        <div id="header-wrap">

            <div class="container clearfix">

                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                <!-- Logo
                ============================================= -->
                <div id="logo">
                    <a href="/" class="standard-logo" data-dark-logo="/assets/images/logo-dark.png"><img src="/assets/images/logo.png" alt="Logo"></a>
                    <a href="/" class="retina-logo" data-dark-logo="/assets/images/logo-dark@2x.png"><img src="/assets/images/logo@2x.png" alt="Logo"></a>
                </div><!-- #logo end -->

                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu" class="dark">


                    <ul>
                        <?php
                        $i = 0;
                        foreach ( $ci->menu->list as $mainMenuName => $mainMenu ) {
                            if ( in_array( $ci->menu->accountType, $mainMenu['available_account_type'] ) && $mainMenu['visible'] ) {
                                ?>
                                <li class="<?php echo ( $mainMenu['v'] == $ci->menu->current[0]['v'] ) ? "current" : ""?>">
                                    <a href="/<?php echo ( $mainMenu['sub'] != NULL ) ? "#" : $mainMenu['v']?>"><div><?php echo $mainMenuName;?></div></a>
                                    <?php if ( $mainMenu['sub'] != NULL ) { ?>
                                        <ul>
                                            <?php foreach ( $mainMenu['sub'] as $subMenuName => $subMenu ) {
                                                if ( in_array( $ci->menu->accountType, $subMenu['available_account_type'] ) ) {?>
                                                    <li><a href="/<?php echo "{$mainMenu['v']}/{$subMenu['v']}"?>"><div><?php echo $subMenuName;?></a></div></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->