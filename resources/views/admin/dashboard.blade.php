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
                        <h3>{{ $applications_count }}</h3>

                        <p>APPLICATIONS</p>
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
                        <h3>{{ $approved_applications_count }}</h3>

                        <p>APPROVE APPLICATION</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $products_count }}</h3>

                        <p>PRODUCTS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>&#8369;10,000</h3>

                        <p>TOTAL DUE (dapat bayaran)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applications</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Brand</th>
                                        <th>Down Payment</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($applications)
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ ucwords($application->user->full_name) }}</td>
                                        <td><strong>Product 1</strong></td>
                                        <td>Honda</td>
                                        <td><strong>50,000</strong></td>
                                        <td>{{ date('F j, Y g:i a', strtotime($application->created_at)) . ' | ' . $application->created_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{ url('/') }}" class="btn btn-primary btn-sm">view</a>
                                            <a href="{{ url('/') }}" class="btn btn-success btn-sm">approve</a>
                                            <a href="{{ url('/') }}" class="btn btn-danger btn-sm">decline</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <div class="alert alert-warning">
                                        <strong>No data.</strong>
                                    </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Due</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong></strong></td>
                                    </tr>
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