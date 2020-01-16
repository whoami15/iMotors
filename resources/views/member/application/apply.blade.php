@extends('layouts.backend.master')

@section('title', 'Application')

@section('header_scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor-container {
        height: 175px;
    }
    .form-control {
        border: 2px solid #848484!important;
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
                                    <label for="product_id">Product</label>
                                    <select class="form-control" name="product_id" required>
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
                            <label for="present_address">Present Address (No. / Street / Brgy / Municipality / Province / ZipCode)</label>
                            <input type="text" class="form-control" name="present_address" value="{{ old('present_address') }}" placeholder="Present address" required>
                        </div>
                        <div class="form-group">
                            <label for="previous_address">Previous Address (No. / Street / Brgy / Municipality / Province / ZipCode)</label>
                            <input type="text" class="form-control" name="previous_address" value="{{ old('previous_address') }}" placeholder="Previous address" required>
                        </div>
                        <div class="form-group">
                            <label for="provincial_address">Provincial Address (No. / Street / Brgy / Municipality / Province / ZipCode)</label>
                            <input type="text" class="form-control" name="provincial_address" value="{{ old('provincial_address') }}" placeholder="Provincial address" required>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    <input type="text" class="form-control" name="civil_status" value="{{ old('civil_status') }}" placeholder="Civil status" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mobile">Contact no.</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="Contact no. : 09xx" required>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tin">TIN</label>
                                    <input type="text" class="form-control" name="tin" value="{{ old('tin') }}" placeholder="TIN" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="birth_place">Birth Place</label>
                                    <input type="text" class="form-control" name="birth_place" value="{{ old('birth_place') }}" placeholder="Birth place address" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="birth_date">Birthdate</label>
                                    <input type="date" class="form-control" name="birth_date" placeholder="Birthdate" max="2005-01-01" min="1930-01-01" format="yyyy-mm-dd" id="birth_date" id="birth_date" onchange="submitBday()" id="birth_date" onchange="submitBday()" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="text" class="form-control" name="age" value="{{ old('age') }}" placeholder="Age" id="age" readonly required>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="educational_attainment">Educational Attainment</label>
                                    <input type="text" class="form-control" name="educational_attainment" value="{{ old('educational_attainment') }}" placeholder="Educational Attainment" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course">Course</label>
                                    <input type="text" class="form-control" name="course" value="{{ old('course') }}" placeholder="Course" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="school">School</label>
                                    <input type="text" class="form-control" name="school" value="{{ old('school') }}" placeholder="School" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year_graduated">Year Graduated</label>
                                    <input type="text" class="form-control" name="year_graduated" value="{{ old('year_graduated') }}" placeholder="Year graduated" required>
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
<script>
    function submitBday() {
        var Q4A = "";
        var Bdate = document.getElementById('birth_date').value;
        var Bday = +new Date(Bdate);
        Q4A +=  ~~ ((Date.now() - Bday) / (31557600000));
        var theBday = document.getElementById('age');
        theBday.value = Q4A;
    }
</script>
@stop