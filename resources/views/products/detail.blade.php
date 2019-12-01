@extends('layouts.frontend.master')

@section('title', $product->title)

@section('content')
<section class="categories_banner_area">
    <div class="container">
        <div class="c_banner_inner">
            <h3>{{ $product->title }}</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="{{ url('/') }}">Shop</a></li>
                <li class="current"><a href="#">{{ $product->title }}</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="product_details_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="product_details_slider">
                    <div id="product_slider2" class="rev_slider" data-version="5.3.1.6">
                        <ul>
                            @foreach($product->photos as $photo)
                            <li data-index="rs-28{{ $photo->id }}" data-transition="scaledownfromleft" data-slotamount="default"  data-easein="default" data-easeout="default" data-masterspeed="1500"  data-thumb="{{ $photo->filename }}"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off">
                                <!-- MAIN IMAGE -->
                                <img src="{{ $photo->filename }}" alt="{{ $product->title }}" width="1920" height="1080" data-lazyload="{{ $photo->filename }}" data-bgposition="center center" data-bgfit="contain" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                                <!-- LAYERS -->
                            </li>
							@endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="product_details_text">
                    <h3>{{ $product->title }}</h3>
                    @if($product->stock > 0)
                    <h6>Available In <span>Stock</span></h6>
                    @else
                    <h6>Unavailable <span class="text-danger">Out of Stock</span></h6>
                    @endif
                    <h4>&#8369;{{ number_format($product->price) }}</h4>
                    {!! $product->description !!}
                    @auth()
                    <a class="mt-3 add_cart_btn" href="{{ url('/application?product='.$product->id) }}">APPLY NOW</a>
                    @else
                    <a class="mt-3 add_cart_btn" href="{{ url('/login') }}">APPLY NOW</a>
                    @endauth
                    <div class="mt-3 shareing_icon">
                        <h5>share :</h5>
                        <ul>
                            <li><a href="https://www.facebook.com/sharer.php?u={{ url('/product/'.$product->slug) }}" target="_blank"><i class="social_facebook"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?url={{ url('/product/'.$product->slug) }}&text={{ $product->title }}" target="_blank"><i class="social_twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product_description_area">
    <div class="container">
        <nav class="tab_menu">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
                <a class="nav-item nav-link" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="false">additional information</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                {!! $product->description !!}
            </div>
            <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                <span style="font-size:18px;">Price:</span> <span style="font-size:19px;font-weight:600;">SRP &#8369;{{ number_format($product->price) }}</span><br/>
                <span style="font-size:18px;">Down Payment:</span> <span style="font-size:19px;font-weight:600;">&#8369;{{ number_format($product->down_payment) }}</span><br/>
                <hr/>
                <span style="font-size:18px;">Brand:</span> <span style="font-size:19px;font-weight:600;">{{ $product->product_brand }}</span><br/>
                <span style="font-size:18px;">Motor Type:</span> <span style="font-size:19px;font-weight:600;">{{ $product->brand_type }}</span><br/>
                <hr/>
                <span style="font-size:18px;">Branch:</span> <span style="font-size:19px;font-weight:600;">{{ $product->branch }}</span><br/>
                <span style="font-size:18px;">Payment:</span> <span style="font-size:19px;font-weight:600;">Up to {{ $product->payment_length }} Months!</span><br/>
            </div>
        </div>
    </div>
</section>
@endsection