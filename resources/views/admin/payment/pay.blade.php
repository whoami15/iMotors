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
<section class="content">
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

                    <form method="POST" action="{{ url('/admin/loan/pay') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="addForm">
                        {!! csrf_field() !!}

                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label for="title">Loan Code</label>
                                <input type="text" class="form-control" name="loan_code" value="{{ old('loan_code') }}" placeholder="Loan Code" required>
                            </div>
                            <div class="form-group">
                                <label for="payment_length">Username or Email</label>
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username or Email" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Amount to Pay (&#8369;)</label>
                                <input type="text" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Amount to Pay" required>
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
@stop