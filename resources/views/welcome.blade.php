<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es" ng-app="App"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es" ng-app="App"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es" ng-app="App"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es" ng-app="App"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>TITULO</title>
      <link rel="icon" href="{{asset('images/favicon.png')}}">

    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-theme.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/default.css')}}" rel="stylesheet">
    <link href="{{asset('css/simple-sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('css/sequence.css')}}" rel="stylesheet">
      <link href="{{asset('css/font-Lobster.css')}}" rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

      <script>window.jQuery || document.write('<script src="{{asset('js/jquery.js')}}"><\/script>')</script>
      <script src="{{asset('js/bootstrap.min.js')}}"></script>
      <script src="{{asset('js/jquery.sequence-min.js')}}"></script>
<!--      <script src="{{asset('js/angular.min.js')}}"></script>   -->
      <script src="{{asset('js/default.js')}}"></script>

      <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
      <!--<script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X','auto');ga('send','pageview');
  </script>-->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
      <![endif]-->
    <!-- Add your menu here-->
    <!--<nav class="navbar navbar-default">-->
    <nav class="navbar navbar-inverse" role="navigation">
        <!--<div class="container-fluid">-->
        <div class="container">
            <div class="navbar-header">
                <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">-->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="TITULO">
                    <img alt="Cofaral Encuestas" src="{{asset('images/iconMenu.png')}}" style="width: 40px; margin-top: -5px;">
                    <a class="navbar-brand fuente fuente25" href="">TITULO</a>
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!-- itemMenuSimplePHP -->
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    <!-- Add Here your view-->
    <div class="container-fluid sinPadd sinMargen">
      AQUI VA LA WEB


      @include('admin')
      @include('encuesta')



        <footer>
            <hr>
            <p>&copy; Cofaral 2019</p>
        </footer>
    </div>  
      <!-- Footer here-->
  </body>
</html>