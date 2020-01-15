<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ URL::asset('assets/frontend/favicon/favicon.png') }}" type="image/x-icon" />
  <link rel="shortcut icon" href="{{ URL::asset('assets/frontend/favicon/favicon.png') }}">
  <meta name="_token" content="{!! csrf_token() !!}">
  <title>@yield('title') | iMotors Motor Loan Services</title>
  <meta name="author" content="MinSCAT Students">
  <meta name="description" content="iMotors Motor Loan Services the Official Website of Motorlandia">
  <link rel="canonical" href="{{ url()->full() }}"/>
  <meta property="og:title" content="iMotors Motor Loan Services">
  <meta property="og:locale" content="en_US">
  <meta property="og:image" content="{{ URL::asset('assets/frontend/images/og_image.jpg') }}">
  <meta property="og:image:width" content="400"> 
  <meta property="og:image:height" content="300">
  <meta property="og:description" content="iMotors Motor Loan Services the Official Website of Motorlandia">
  <meta property="og:url" content="http://motorlandiacalapan2.com">
  <meta property="og:site_name" content="iMotors Motor Loan Services the Official Website of Motorlandia">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:image:alt" content="Cover">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/jqvmap/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/summernote/summernote-bs4.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <script type="application/ld+json">
    {
      "name": "iMotors Motor Loan Services",
      "description": "The Official Website of Motorlandia",
      "author":
      {
        "@type": "Person",
        "name": "MinSCAT Students"
      },
      "@type": "WebSite",
      "url": "",
      "headline": "The Official Website of Motorlandia",
      "@context": "http://schema.org"
    }
  </script>

  @yield('header_scripts')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('layouts.backend.inc.sidebar')

    @include('layouts.backend.inc.header')

    <div class="content-wrapper">
      @yield('content')
    </div>

    @include('layouts.backend.inc.footer')

  </div>

    <script src="{{ URL::asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ URL::asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/adminlte.js') }}"></script>
    
    <script src="{{ URL::asset('assets/plugins/angular/angular.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js') }}"></script>

    @yield('footer_scripts')

</body>
</html>
<!-- l3g10n
        (___()'`; (MEOW)
        /,    /`
        \\"--\\
    ~~~~~~~~~~~~~~-->