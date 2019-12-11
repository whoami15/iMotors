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

                    <form method="POST" action="{{ url('application') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="addForm">
                        {!! csrf_field() !!}
                        <h3>
                            @if($loan)
                            @php
                            $dt     = \Carbon\Carbon::now();
                            $past   = $loan->created_at;
                            @endphp
                            Month(s) to Pay: {{ $past->diffInMonths($dt) }}
                            @endif
                        </h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <select class="form-control" name="purpose" required>
                                        <option value="" selected disabled>Choose</option>
                                        <option value="SERVICE">SERVICE</option>
                                        <option value="PASSENGER">PASSENGER</option>
                                        <option value="DELIVERY">DELIVERY</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit_user">Who will use</label>
                                    <input type="text" class="form-control" name="unit_user" value="{{ old('unit_user') }}" placeholder="Who will use" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Down Payment (&#8369;)</label>
                                    <input type="text" class="form-control" name="down_payment" value="{{ old('down_payment') }}" placeholder="&#8369;" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_length">Payment Length (in Months)</label>
                                    <input type="text" class="form-control" name="payment_length" value="{{ old('payment_length') }}" placeholder="e.g.: 36" required>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="title">Photos</label>
                            <input type="file" name="photos[]" accept=".png, .jpg, .jpeg" multiple/>
                        </div>
                        <button type="submit" id="add_product_btn" class="btn btn-primary btn-block mt-30" type="submit">APPLY NOW</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>                 
@endsection
@section('footer_scripts')
@stop