<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ URL::asset('assets/frontend/favicon/favicon.png') }}" type="image/x-icon" />
  <link rel="shortcut icon" href="{{ URL::asset('assets/frontend/favicon/favicon.png') }}">
  <meta name="_token" content="{!! csrf_token() !!}">
  <title>Invoice | iMotors Motor Loan Services</title>
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
  <style>
        body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer, body:not(.sidebar-mini-md) .main-header {
            transition: margin-left .3s ease-in-out;
            margin-left: 0 !important;
        }
    </style>
</head>
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            This page has been enhanced for printing. Click the print button at the bottom of the
                            invoice to test.
                        </div>
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> iMotors Motor Loan Services
                                        <small class="float-right">{{ date('D, F j, Y', strtotime($payment->created_at)) .' | '. $payment->created_at->diffForHumans() }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <h3>INVOICE</strong></h3>
                            <hr/>
                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    BASIC INFORMATION
                                    <address>
                                        <strong>Name:</strong> {{ strtoupper($payment->user->first_name .' '. $payment->user->middle_name .' '. $payment->user->last_name) }}<br>
                                        <strong>Civil Status: </strong>{{ strtoupper($payment->application->civil_status) }}<br>
                                        <strong>Sex:</strong> {{ $payment->application->sex }}<br>
                                        <strong>Age:</strong> {{ $payment->application->age }}<br>
                                        <strong>Birth Date:</strong> {{ date('F j, Y', strtotime($payment->application->birth_date)) }}<br>
                                        <strong>Phone:</strong> {{ $payment->application->mobile }}<br>
                                        <strong>Present Address:</strong> {{ $payment->application->present_address }}<br>
                                        <strong>TIN:</strong> {{ $payment->application->tin }}
                                    </address>
                                </div>
                            </div>
                            <!-- /.row -->
                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Brand</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="{{ url('/product/'.$payment->application->product->slug) }}" target="_blank" title="Click to open">{{ $payment->application->product->title }}</a></td>
                                                <td>{{ $payment->application->product->product_brand }}</td>
                                                <td>{{ $payment->application->product->brand_type }}</td>
                                                <td>&#8369;{{ number_format($payment->application->product->price) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <p class="lead">Info:</p>
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Next payment date is 1 month after approval of payment.
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <p class="lead">Payment</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <th>PAID AMOUNT:</th>
                                                <td><h5>{{ number_format($payment->amount) }}</h5></td>
                                            </tr>
                                            <tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <button type="button" class="btn btn-success float-right print-window"><i class="far fa-credit-card"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
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

    <script>
        $('.print-window').click(function() {
            window.print();
        });
    </script>
</body>
</html>