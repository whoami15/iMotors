@extends('layouts.backend.master')

@section('title', 'Pay')

@section('header_scripts')
@stop

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pay</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pay</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content" ng-app="applicationApp" ng-controller="ApplicationCtrl as frm">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pay</h3>
                </div>
                <div class="card-body">

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

                    @if($loan)
                    <h3 class="text-center text-bold mb-2 mt-2">BALANCE: &#8369;{{ number_format($balance) }}</h3>
                    <h3 class="text-center text-bold mb-5 mt-2"><u>No. of Month(s) to Pay: {{ $months_to_pay }} (&#8369;{{ number_format($monthly_payment * $months_to_pay) }})</u></h3>
                    @endif
                    
                    <form method="POST" action="{{ url('/loan/'.$loan->id.'/pay') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="addForm">
                        {!! csrf_field() !!}

                        <div class="col-md-6 offset-md-3">
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
                                                <td><a href="{{ url('/product/'.$loan->product->slug) }}" target="_blank" title="Click to open">{{ $loan->product->title }}</a></td>
                                                <td>{{ $loan->product->product_brand }}</td>
                                                <td>{{ $loan->product->brand_type }}</td>
                                                <td>&#8369;{{ number_format($loan->product->price) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr/>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Your Down Payment (&#8369;)</label>
                                        <input type="text" class="form-control" name="down_payment" value="{{ $loan->down_payment }}" placeholder="&#8369;" readonly disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_length">Payment this Month</label>
                                        @if($months_to_pay > 0)
                                        <input type="text" class="form-control" name="amount" value="{{ number_format($monthly_payment * $months_to_pay) }}" placeholder="Monthly Payment multiply by month" readonly required>
                                        @else
                                        <input type="text" class="form-control" name="amount" value="{{ number_format($monthly_payment) }}" placeholder="Monthly Payment multiply by month" readonly required>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="payment_length">Mode of Payment</label>
                                        <select class="form-control" name="payment_method" ng-model="frm.payment_method">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="REMITTANCE">REMITTANCE</option>
                                            <option value="PAYPAL">PAYPAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3" ng-if="frm.payment_method == 'REMITTANCE'">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="payment_length">Reference Number</label>
                                        <input type="text" class="form-control" name="reference_number" value="{{ old('reference_number') }}" placeholder="Reference Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_length">Sender Full Name</label>
                                        <input type="text" class="form-control" name="sender_name" value="{{ old('sender_name') }}" placeholder="Sender Full Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_length">Sender Mobile no.</label>
                                        <input type="text" class="form-control" name="sender_mobile" value="{{ old('sender_mobile') }}" placeholder="Sender Mobile no.">
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <button type="submit" id="add_product_btn" class="btn btn-primary btn-block mt-30" type="submit">PAY NOW</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>                 
@endsection
@section('footer_scripts')
<script src="{{ URL::asset('assets/plugins/angular/angular.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/ui-bootstrap/ui-bootstrap.min.js')  }}"></script>

<script type="text/javascript">
    (function () {
        var applicationApp = angular.module('applicationApp', ['angular.filter']);
        applicationApp.controller('ApplicationCtrl', function ($scope, $http, $sce) {

            var vm = this;

        });
    })();

</script>
@stop