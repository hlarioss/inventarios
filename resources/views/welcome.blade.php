@extends('layouts.app')

@section('content')
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>SAI</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!--        <link rel="stylesheet" href="/../../sfi/sfi/css/bootstrap-theme.min.css">-->


    <!--For Plugins external css-->
    <link rel="stylesheet" href="/css/plugins.css" />
    <link rel="stylesheet" href="/css/magnific-popup.css">

    <!--Theme custom css -->

    <!--Theme Responsive css-->
    <link rel="stylesheet" href="/sfi/css/responsive.css" />

    <script src="/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <!--Home page style-->
    <header id="home" class="home home-main-content">
        <br>
        <br>
        <br>
        <div class="container">
            <div class="row">
                <div class="home-wrapper">
                    <div class="col-sm-6 col-xs-12">
                        <div class="home-content">
                            <br>
                            <br>
                            <h1><strong text_align="center">Sistema de Control de Inventarios </strong></h1>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xs-12">
                        <div class="home-photo">
                            <img src="/images/car_zone.jpg" alt="SCI" / width="550">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </header>

    
    <div class="scroll-top">

        <div class="scrollup">
            <i class="fa fa-angle-double-up"></i>
        </div>

    </div>
    
    <!--Footer-->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row">
                <div class="wrapper">
                    <div class="col-sm-6 col-sm-offset-3 col-xs-12">
                        <div class="footer-item text-center">


                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="footer-copyright-area">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="footer-copy-right">
                                                <p>Copyright ©<a target="blank" href="">Hiarold Oscar Larios Seijas</a>
                        . All rights reserved. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="/js/vendor/jquery-1.11.2.min.js"></script>
    <script src="/js/vendor/bootstrap.min.js"></script>

    <script src="/js/plugins.js"></script>
    <script src="/js/jquery.mixitup.min.js"></script>
    <script src="/js/jquery.easypiechart.min.js"></script>
    <script src="/js/jquery.magnific-popup.js"></script>
    <script src="/js/modernizr.js"></script>
    
    <script src="/js/main.js"></script>
</body>
</html>

@endsection
