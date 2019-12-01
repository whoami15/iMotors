@extends('layouts.backend.master')

@section('title', 'Application')

@section('header_scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor-container {
        height: 175px;
    }
</style>
@stop

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Application</li>
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
                    <h3 class="card-title">Application</h3>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">Product</label>
                                    <select class="form-control" name="product_brand" required>
                                        <option value="" selected disabled>Choose</option>
                                        @php
                                        $product_id = 0;
                                        if(isset($_GET['product'])){
                                            $product_id = $_GET['product'];
                                        }
                                        @endphp
                                        @if($products)
                                            @foreach($products as $p)
                                            <option value="{{ $p->id }}" {{ ($p->id == $product_id) ? 'selected' : '' }}>{{ $p->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch">Purpose</label>
                                    <select class="form-control" name="branch" required>
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
                                    <input type="text" class="form-control" name="unit_user" value="{{ old('unit_user') }}" placeholder="Who will use">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="present_address">Present Address</label>
                                    <input type="text" class="form-control" name="present_address" value="{{ old('present_address') }}" placeholder="Complete address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="municipality">Municipality</label>
                                    <input type="text" class="form-control" name="municipality" value="{{ old('municipality') }}" placeholder="Municipality">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    <input type="text" class="form-control" name="civil_status" value="{{ old('civil_status') }}" placeholder="Civil status">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mobile">Contact no.</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="Contact no. : 09xx">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="text" class="form-control" name="age" value="{{ old('age') }}" placeholder="Age">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sex">Sex</label>
                                    <select class="form-control" name="sex" required>
                                        <option value="" selected disabled>Choose</option>
                                        <option value="MALE">MALE</option>
                                        <option value="FEMALE">FEMALE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Down Payment (&#8369;)</label>
                                    <input type="text" class="form-control" name="down_payment" value="{{ old('down_payment') }}" placeholder="&#8369;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Price (&#8369;)</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="&#8369;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Payment Length (in Months)</label>
                                    <input type="text" class="form-control" name="payment_length" value="{{ old('payment_length') }}" placeholder="e.g.: 36">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Photos</label>
                            <input type="file" name="photos[]" accept=".png, .jpg, .jpeg" required multiple/>
                        </div>
                        <button type="submit" id="add_product_btn" class="btn btn-primary mt-30" type="submit">APPLY</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>                 
@endsection
@section('footer_scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: [
            ['bold', 'italic'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ]
        },
        theme: 'snow'  // or 'bubble'
    });

    $(document).ready(function(){
        $("#addForm").on("submit", function () {
            //var hvalue = $('#editor-container').html();
            var hvalue = quill.root.innerHTML;
            $(this).append("<textarea name='description' style='display:none'>"+hvalue+"</textarea>");
        });
    });
</script>
@stop