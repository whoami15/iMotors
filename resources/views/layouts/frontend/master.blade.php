<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
    <link href="{{ URL::asset('assets/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/line-icon/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/elegant-icon/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/revolution/css/settings.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/revolution/css/layers.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/revolution/css/navigation.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/vendors/bootstrap-selector/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/css/responsive.css') }}" rel="stylesheet">
    
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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    @include('layouts.frontend.inc.header')

    @if(request()->is('/'))
    @include('layouts.frontend.inc.carousel')
    @endif

      @yield('content')

    @include('layouts.frontend.inc.footer')

    <script src="{{ URL::asset('assets/frontend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/counterup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/bootstrap-selector/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/image-dropdown/jquery.dd.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/js/smoothscroll.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/magnify-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/vertical-slider/js/jQuery.verticalCarousel.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/js/theme.js') }}"></script>

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