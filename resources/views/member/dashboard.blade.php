@extends('layouts.backend.master')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $summary['application_pending_count'] }}</h3>

                        <p>PENDING APPLICATION</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $summary['application_approved_count'] }}</h3>

                        <p>APPROVED APPLICATION</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>&#8369;{{ number_format($due['total_due']) }}</h3>

                        <p>{{ $due['months_to_pay'] }} Month(s) | DUE (dapat bayaran)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>&#8369;{{ number_format($summary['balance']) }}</h3>

                        <p>BALANCE (total ng dapat bayaran)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applications</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Brand</th>
                                        <th>Down Payment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($applications)
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->product->title }}</td>
                                        <td>{{ $application->product->product_brand }}</td>
                                        <td>&#8369;{{ number_format($application->down_payment) }}</td>
                                        <td>
                                            @if($application->status == 'PENDING')
                                                <span class="text-warning">PENDING</span>
                                            @elseif($application->status == 'APPROVED')
                                                <span class="text-success">APPROVED</span>
                                            @elseif($application->status == 'DECLINED')
                                                <span class="text-danger">DECLINED</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ url('/application/view/'.$application->id) }}">View</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Due</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Last Payment Date</th>
                                        <th>DUE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($loans)
                                    @foreach($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->product->title }}</td>
                                        <td>{{ date('F j, Y g:i a', strtotime($loan->last_payment_date)) }}</td>
                                        <td>
                                            @php
                                                $dt = \Carbon\Carbon::now();
                                                $past = \Carbon\Carbon::parse($loan->last_payment_date);
                                                $final = $past->format('Y-m-d');
                                                $count_unpaid = $past->diffInMonths($dt);
                                            @endphp
                                            @if($loan->payment)
                                                @if($count_unpaid > 0) 
                                                    <a class="btn btn-danger btn-sm" href="{{ url('/loan/pay/'.$loan->id) }}" target="_blank"><strong>DUE | PAY<i class="fa fa-arrow-right"></i></strong></a>
                                                @else
                                                    <a class="btn btn-success btn-sm" href="{{ url('/loan/pay/'.$loan->id) }}" target="_blank"><strong>PAY<i class="fa fa-arrow-right"></i></strong></a>
                                                @endif
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection