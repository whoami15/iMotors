@extends('layouts.backend.master')

@section('title', 'View Application')

@section('header_scripts')
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">View Application</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    This page has been enhanced for printing. Click the print button at the bottom of the
                    invoice to test.
                </div>
                @if($application->status == 'PENDING' || $application->status == 'DECLINED')
                <div class="invoice p-3 mb-3">
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                    {!! session('success') !!}
                    </div>
                    @endif

                    @if(session('danger'))
                    <div class="alert alert-warning" role="alert">
                    {!! session('danger') !!}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-warning" role="alert">
                        @foreach ($errors->all() as $error)
                        * {{ $error }}<br>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ url('/admin/application/'.$application->id.'/update') }}" method="POST">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>UPDATE STATUS</label>
                                    <select class="form-control" name="status" required>
                                        <option value="PENDING" {{ ($application->status) == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                        <option value="APPROVED" {{ ($application->status) == 'APPROVED' ? 'selected' : '' }}>APPROVED</option>
                                        <option value="DECLINED" {{ ($application->status) == 'DECLINED' ? 'selected' : '' }}>DECLINED</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>FILL THIS (If DECLINED)</label>
                                    <textarea class="form-control" name="reason" rows="2" placeholder="Enter ..."></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-primary">UPDATE</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> iMotors Motor Loan Services
                                <small class="float-right">{{ date('D, F j, Y', strtotime($application->created_at)) .' | '. $application->created_at->diffForHumans() }}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    @if($application->status == "PENDING")
                    <div class="alert alert-warning mt-2" role="alert">
                        Your Application is <strong>{{ strtoupper($application->status) }}</strong>.
                    </div>
                    @elseif($application->status == "APPROVED")
                    <div class="alert alert-success mt-2" role="alert">
                        Your Application is <strong>{{ strtoupper($application->status) }}</strong>.
                    </div>
                    @elseif($application->status == "DECLINED")
                    <div class="alert alert-danger mt-2" role="alert">
                        Your Application is <strong>{{ strtoupper($application->status) }}</strong>.
                    </div>
                    @endif

                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            BASIC INFORMATION
                            <address>
                                <strong>Name:</strong> {{ strtoupper($application->user->first_name .' '. $application->user->middle_name .' '. $application->user->last_name) }}<br>
                                <strong>Civil Status: </strong>{{ strtoupper($application->civil_status) }}<br>
                                <strong>Sex:</strong> {{ $application->sex }}<br>
                                <strong>Age:</strong> {{ $application->age }}<br>
                                <strong>Birth Date:</strong> {{ date('F j, Y', strtotime($application->birth_date)) }}<br>
                                <strong>Phone:</strong> {{ $application->mobile }}<br>
                                <strong>Present Address:</strong> {{ $application->present_address }}<br>
                                <strong>TIN:</strong> {{ $application->tin }}
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            EDUCATIONAL BACKGROUND
                            <address>
                                <strong>Educational Attainment:</strong> {{ $application->educational_attainment }}<br>
                                <strong>School:</strong> {{ $application->school }}<br>
                                <strong>Year Graduated:</strong> {{ $application->year_graduated }}<br>
                                <strong>Course:</strong> {{ $application->course }}<br>
                            </address>
                        </div>
                        <!-- /.col -->
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <br>
                            <b>PURPOSE:</b> {{ $application->purpose }}<br>
                            <b>WHO WILL USE:</b> {{ $application->unit_user }}<br>
                            <b>BRANCH:</b> {{ $application->branch }}
                        </div>
                        <!-- /.col -->
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
                                        <td><a href="{{ url('/product/'.$application->product->slug) }}" target="_blank" title="Click to open">{{ $application->product->title }}</a></td>
                                        <td>{{ $application->product->product_brand }}</td>
                                        <td>{{ $application->product->brand_type }}</td>
                                        <td>&#8369;{{ number_format($application->product->price) }}</td>
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
                                Next payment date is 30 days after approval of application. (pag approve. update ng last_payment_date sa db)
                            </p>
                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                <strong>Item price - (minus) Down payment / (divided by) Payment Length (months)</strong>
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <p class="lead">Payment</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">DOWN PAYMENT:</th>
                                        <td><h5>&#8369;{{ number_format($application->down_payment) }}</h5></td>
                                    </tr>
                                    <th>MONTHS TO PAY:</th>
                                        <td><h5>{{ $application->payment_length }}</h5></td>
                                    </tr>
                                    <tr>
                                        <th>MONTHLY PAYMENT:</th>
                                        <td><h3>&#8369;{{ number_format($monthly_payment) }}</h3></td>
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
                            <a href="invoice-print.html" target="_blank" class="btn btn-default"><i
                                    class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('footer_scripts')
@endsection