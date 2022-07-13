<?php 
if (isset($_SESSION['username'])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PIN | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://pin.kemdikbud.go.id/pin//asset/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pin.kemdikbud.go.id/pin//asset/css/custom.css">

    <link rel="stylesheet" href="https://pin.kemdikbud.go.id/pin/asset/belmawa/reset.css" type="text/css"
        media="screen, projection" />
    <link rel="stylesheet" href="https://pin.kemdikbud.go.id/pin/asset/belmawa/defaults.css" type="text/css"
        media="screen, projection" />
    <!--[if lt IE 8]><link rel="stylesheet" href="https://pin.kemdikbud.go.id/pin/asset/belmawa/ie.css" type="text/css" media="screen, projection" /><![endif]-->

    <link href="https://pin.kemdikbud.go.id/pin//asset/css/logo.css" rel="stylesheet">


    <link rel="alternate" type="application/rss+xml"
        title="Direktorat Jenderal Pendidikan Tinggi &raquo; Tawaran Program Insentif Pengembangan Bahan Ajar dan Pedoman Pembelajaran dengan Pendekatan Student Centered Learning (SCL) Comments Feed"
        href="http://dikti.kemdikbud.go.id/dev/index.php/2016/04/15/tawaran-program-insentif-pengembangan-bahan-ajar-dan-pedoman-pembelajaran-dengan-pendekatan-student-centered-learning-scl/feed/" />

    <link rel='stylesheet' id='orgchart-style1-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/jquery.jOrgChart.css?ver=4.3.1' type='text/css'
        media='all' />
    <link rel='stylesheet' id='orgchart-style2-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/custom.css?ver=4.3.1' type='text/css' media='all' />
    <link rel='stylesheet' id='category-posts-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/cat-posts.css?ver=4.3.1' type='text/css' media='all' />
    <link rel='stylesheet' id='tribe-events-full-calendar-style-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/tribe-events-full.min.css?ver=3.12.6' type='text/css'
        media='all' />
    <link rel='stylesheet' id='tribe-events-calendar-style-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/tribe-events-theme.min.css?ver=3.12.6' type='text/css'
        media='all' />
    <link rel='stylesheet' id='tribe-events-calendar-full-mobile-style-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/tribe-events-full-mobile.min.css?ver=3.12.6' type='text/css'
        media='only screen and (max-width: 768px)' />
    <link rel='stylesheet' id='tribe-events-calendar-mobile-style-css'
        href='https://pin.kemdikbud.go.id/pin/asset/belmawa/tribe-events-theme-mobile.min.css?ver=3.12.6'
        type='text/css' media='only screen and (max-width: 768px)' />



    <!-- START PLUGINS -->
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin//asset/js/plugins/jquery/jquery-2.1.3.js">
    </script>
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin//asset/js/plugins/jquery/jquery-ui.min.js">
    </script>
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin//asset/js/plugins/bootstrap/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin//asset/js/plugins/summernote/summernote.js">
    </script>
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin//asset/js/plugins/dropzone/dropzone.min.js">
    </script>

    <script type='text/javascript' src='https://pin.kemdikbud.go.id/pin/asset/belmawa/superfish.js?ver=4.3.1'></script>
    <script type='text/javascript' src='https://pin.kemdikbud.go.id/pin/asset/belmawa/jquery.mobilemenu.js?ver=4.3.1'>
    </script>

    <link rel="shortcut icon" href="https://pin.kemdikbud.go.id/pin/asset/belmawa/favicon1.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="Direktorat Jenderal Pendidikan Tinggi RSS Feed"
        href="http://dikti.kemdikbud.go.id/dev/index.php/feed/" />
    <link rel="stylesheet" href="https://pin.kemdikbud.go.id/pin/asset/belmawa/jquery-ui.min.css" type="text/css" />
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin/asset/belmawa/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="https://pin.kemdikbud.go.id/pin/asset/belmawa/jquery-ui.min.js"></script>

</head>

<body class="single single-post postid-1512 single-format-standard">
    <div id="container">
        <div class="clearfix">
            <div class="menu-primary-container">
                <ul id="menu-menu-atas" class="menus menu-primary">
                    <li id="menu-item-87"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-87"><a
                            href="http://kemdikbud.go.id/">KEMDIKBUD</a></li>
                    <li id="menu-item-87"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-87"><a
                            href="http://dikti.kemdikbud.go.id/">Ditjen Dikti</a></li>
                </ul>
            </div>
            <!--.primary menu-->

            <div id="top-social-profiles">
                <ul class="widget-container">
                    <li class="social-profiles-widget">
                    </li>
                </ul>
            </div>
        </div>

        <div id="header">
            <div class="logo">
                <a href="http://dikti.kemdikbud.go.id/" style="float:left;"><img
                        src="https://pin.kemdikbud.go.id/pin/asset/belmawa/logokemdikbud.png"
                        alt="Direktorat Jenderal Pendidikan Tinggi" title="Direktorat Jenderal Pendidikan Tinggi" /></a>
                <!-- added by benirio start -->
                <h1 class="site_title"><a href="http://dikti.kemdikbud.go.id/">Direktorat Jenderal Pendidikan Tinggi</a>
                </h1>
                <h2 class="site_description">Kementerian Pendidikan dan Kebudayaan</h2>
                <!-- added by benirio end -->
            </div><!-- .logo -->

            <!--
        <div class="header-right">
        -->
            <!--
        </div>
        -->
            <!-- .header-right -->
        </div><!-- #header -->
        <div class="clearfix">
            <div class="menu-secondary-container">
            </div>
            <!--.secondary menu-->
        </div>

        <div id="main" style="font-size:100%">
            <div id="contentt">

                <div class="middle-box-login  loginscreen-login">
                    <div>
                        <div>
                            <!--<h1 class="logo-name"><img src="https://pin.kemdikbud.go.id/pin//asset/img/dikti2.png"></h1>-->
                            <script>
                                $(document).ready(function () {
                                    $(".sk-spinner").hide();

                                    $('form').submit(function () {
                                        $(".sk-spinner").show();

                                    })
                                });
                            </script>


                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>

                        </div>
                        <br><br>
                        <h3 class="text-center"><strong>Selamat Datang di Sistem PIN</strong></h3>
                        <p></p>

                        <form role="form" method="POST" action="/pin-kw/auth.php">
                            <input type="hidden" name="ci_csrf_token" value=""></input>
                            <div class="form-group-login">
                                <input type="text" name="username" class="form-control-login"
                                    placeholder="Masukan Username Anda" required="">
                            </div>
                            <div class="form-group-login">
                                <input type="password" name="password" class="form-control-login"
                                    placeholder="Masukan Password Anda" required="">
                            </div>
                            <div class="form-group-login">
                                <button type="submit"
                                    class="btn-login btn-primary-login block-login full-width-login m-b">
                                    Login
                                </button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>