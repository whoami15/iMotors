<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>iMotors Motor Loan Services</title>
  <meta name="title" content="iMotors Motor Loan Services" />
  <meta name="author" content="MinSCAT Students">
  <meta name="description" content="iMotors Motor Loan Services the Official Website of Motorlandia">
  <link rel="icon" href="{{ asset('favicon.png') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('assets/backend/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('header_scripts')
</head>
<body class="hold-transition {{ (request()->is('login')) ? 'login-page' : 'register-page' }}">

  @yield('content')

  <script src="{{ URL::asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ URL::asset('assets/backend/js/adminlte.min.js') }}"></script>

  @yield('footer_scripts')
</body>
</html>
<!-- l3g10n
        (___()'`; (MEOW)
        /,    /`
        \\"--\\
    ~~~~~~~~~~~~~~-->