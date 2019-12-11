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
                                        <input type="text" class="form-control" name="amount" value="{{ number_format($monthly_payment * $months_to_pay) }}" placeholder="Monthly Payment multiply by month" required>
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
@stop