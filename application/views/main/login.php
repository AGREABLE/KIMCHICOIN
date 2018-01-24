<!DOCTYPE html>
<html lang="en-us">
<head>

    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <!-- Content
    ============================================= -->
    <section id="content">

        <div class="content-wrap nopadding">

            <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: #444;"></div>

            <div class="section nobg full-screen nopadding nomargin">
                <div class="container vertical-middle divcenter clearfix">

                    <div class="row center">
                        <a href="index.html"><img src="/assets/images/logo-dark.png" alt="Logo"></a>
                    </div>

                    <div class="panel panel-default divcenter noradius noborder" style="max-width: 400px;">
                        <div class="panel-body" style="padding: 40px;">
                            <form id="login-form" name="login-form" class="nobottommargin ajaxform" action="/main/ajaxLogin" method="post">
                                <h3>Login to your Account</h3>

                                <div class="col_full">
                                    <label for="login-form-username">Username:</label>
                                    <input type="text" id="login-form-username" name="username" value="" class="form-control not-dark" />
                                </div>

                                <div class="col_full">
                                    <label for="login-form-password">Password:</label>
                                    <input type="password" id="login-form-password" name="password" value="" class="form-control not-dark" />
                                </div>

                                <div class="col_full nobottommargin">
                                    <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row center dark"><small>Copyrights &copy; 2018 All Rights Reserved by <?php echo $ci->config->item( 'service_name' )?> Inc.</small></div>

                </div>
            </div>

        </div>

    </section><!-- #content end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="/assets/canvas/js/functions.js"></script>

</body>
</html>