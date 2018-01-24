<!DOCTYPE html>
<html lang="en-us">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112998047-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-112998047-1');
    </script>


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

    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/assets/css/canvas.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/default.css" type="text/css" />

</head>

<body class="stretched no-transition">

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

                    <?php if ( $ci->menu->accountType > $ci->menu->ACCOUNT_NONE ) { ?>
                    <div id="top-search">
                        <a href="/main/logout"><i class="icon-line-power"></i><i class="icon-line-cross"></i></a>
                    </div>
                    <?php } ?>

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->