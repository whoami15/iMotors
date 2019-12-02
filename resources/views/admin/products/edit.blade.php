@extends('layouts.backend.master')

@section('title', 'Edit Product')

@section('header_scripts')
<link rel="stylesheet" href="{{ URL::asset('assets/backend/css/bootstrap-datepicker.min.css') }}">
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
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/products') }}">Products</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
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
                    <h3 class="card-title">Edit Product</h3>
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

                    <form method="POST" action="{{ url('admin/products/'.$product->id.'/edit') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="editForm">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <select class="form-control" name="product_brand">
                                <option value="" selected disabled>Choose</option>
                                @if($brands)
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_name }}" {{ ($product->product_brand === $brand->brand_name) ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_type">Motor Type</label>
                            <select class="form-control" name="brand_type">
                                <option value="" selected disabled>Choose</option>
                                @if($motor_types)
                                    @foreach($motor_types as $motor_type)
                                    <option value="{{ $motor_type->type }}" {{ ($product->brand_type === $motor_type->type) ? 'selected' : '' }}>{{ $motor_type->type }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="branch">Sub Type</label>
                            <select class="form-control" name="branch">
                                <option value="" selected disabled>Choose</option>
                                @if($branches)
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->branch_name }}" {{ ($product->branch === $branch->branch_name) ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="text" class="form-control" name="stock" value="{{ $product->stock }}" placeholder="e.g.: 8">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Product Name</label>
                                    <input type="text" class="form-control" name="title" value="{{ $product->title }}" placeholder="Product Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Description</label>
                            <div id="editor-container">
                            </div>
                            <textarea class="form-control" name="description" style="display:none;" id="description" placeholder="Description">{{ $product->description }}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Down Payment (&#8369;)</label>
                                    <input type="text" class="form-control" name="down_payment" value="{{ $product->down_payment }}" placeholder="&#8369;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Price (&#8369;)</label>
                                    <input type="text" class="form-control" name="price" value="{{ $product->price }}" placeholder="&#8369;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Payment Length (in Months)</label>
                                    <input type="text" class="form-control" name="payment_length" value="{{ $product->payment_length }}" placeholder="e.g.: 36">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="title">Photos (choose to update photos)</label>
                            <input type="file" name="photos[]" accept=".png, .jpg, .jpeg" multiple/>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="offer_type">Featured</label>
                                    <select class="form-control" name="is_featured">
                                        <option value="" selected disabled>Choose</option>
                                        <option value="1" {{ $product->is_featured === 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $product->is_featured === 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="offer_type">Active</label>
                                    <select class="form-control" name="is_active">
                                        <option value="" selected disabled>Choose</option>
                                        <option value="1" {{ $product->is_active === 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $product->is_active === 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="add_product_btn" class="btn btn-primary mt-30">UPDATE YOUR PRODUCT</button>
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

    var justHtml = $("#description").val();
    console.log(justHtml);
    quill.root.innerHTML = justHtml;

    $(document).ready(function(){
        $("#editForm").on("submit", function () {
            //var hvalue = $('#editor-container').html();
            var hvalue = quill.root.innerHTML;
            $(this).append("<textarea name='description' style='display:none'>"+hvalue+"</textarea>");
        });
    });
</script>
@stop