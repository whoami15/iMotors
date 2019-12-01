@extends('layouts.frontend.master')

@section('title', 'Home')

@section('content')
<section class="our_latest_product">
    <div class="container">
        <div class="s_m_title">
            <h2>Our Latest Products</h2>
        </div>
        <div class="l_product_slider owl-carousel">
            @if($products)
            @foreach($products as $product)
            <div class="item">
                <div class="l_product_item">
                    <div class="l_p_img">
                        <img src="{{ $product->photos->first()['filename'] }}" alt="{{ $product->title }}">
                    </div>
                    <div class="l_p_text">
                        <ul>
                            <li><a class="add_cart_btn" href="{{ url('/product/'.$product->slug) }}">View</a></li>
                        </ul>
                        <h4><a href="{{ url('/product/'.$product->slug) }}" style="font-size:16px;font-family:'Poppins',sans-serif;letter-spacing:.40px;color:#0b1033;font-weight:normal;padding-top:16px;padding-bottom:8px;">{{ str_limit(strip_tags($product->title), $limit = 25, $end = '...') }}</a></h4>
                        <h5>&#8369;{{ number_format($product->price) }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<section class="feature_big_add_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="f_add_item white_add">
                    <div class="f_add_img"><img class="img-fluid" src="{{ URL::asset('assets/frontend/img/feature-add/f-add-4.jpg') }}" alt=""></div>
                    <div class="f_add_hover">
                        <h4>Best Summer <br />Collection</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="f_add_item white_add">
                    <div class="f_add_img"><img class="img-fluid" src="{{ URL::asset('assets/frontend/img/feature-add/f-add-5.jpg') }}" alt=""></div>
                    <div class="f_add_hover">
                        <h4>Best Summer <br />Collection</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product_listing_area">
    <div class="container">
        <div class="row p_listing_inner">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <div class="p_list_text">
                            <h3>Automatic</h3>
                            <ul>
                                @if($products_automatic)
                                @foreach($products_automatic as $products_a)
                                <li><a href="{{ url('/product/'.$products_a->slug) }}">{{ str_limit(strip_tags($products_a->title), $limit = 15, $end = '...') }}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <div class="p_list_img">
                            <img src="{{ URL::asset('assets/frontend/img/product/p-categories-list/product-l-1.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <div class="p_list_text">
                            <h3>Business</h3>
                            <ul>
                                @if($products_business)
                                @foreach($products_business as $product_b)
                                <li><a href="{{ url('/product/'.$product_b->slug) }}">{{ str_limit(strip_tags($product_b->title), $limit = 15, $end = '...') }}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <div class="p_list_img">
                            <img src="{{ URL::asset('assets/frontend/img/product/p-categories-list/product-l-2.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <div class="p_list_text">
                            <h3>Sports</h3>
                            <ul>
                                @if($products_sports)
                                @foreach($products_sports as $product_s)
                                <li><a href="{{ url('/product/'.$product_s->slug) }}">{{ str_limit(strip_tags($product_s->title), $limit = 15, $end = '...') }}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <div class="p_list_img">
                            <img src="{{ URL::asset('assets/frontend/img/product/p-categories-list/product-l-3.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="feature_product_area">
    <div class="container">
        <div class="f_p_inner">
            <div class="row">
                <div class="col-lg-3">
                    <div class="f_product_left">
                        <div class="s_m_title">
                            <h2>Featured Brands</h2>
                        </div>
                        <div class="f_product_inner">
                            <div class="media">
                                <div class="d-flex">
                                    <img src="{{ URL::asset('assets/frontend/img/product/featured-product/honda.png') }}" alt="Honda">
                                </div>
                            </div>
                            <div class="media">
                                <div class="d-flex">
                                    <img src="{{ URL::asset('assets/frontend/img/product/featured-product/yamaha.png') }}" alt="Yamaha">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="fillter_slider_inner">
                        <ul class="portfolio_filter">
                            <li class="active"><a href="#">Featured Products</a></li>
                        </ul>
                        <div class="fillter_slider owl-carousel">
                            @if($featured_products)
                            @foreach($featured_products as $featured)
                            <div class="item">
                                <div class="fillter_product_item">
                                    <div class="f_p_img">
                                        <img src="{{ $featured->photos->first()['filename'] }}" alt="{{ $featured->title }}">
                                    </div>
                                    <div class="f_p_text">
                                        <h5><a href="{{ url('/product/'.$featured->slug) }}" style="font-size:16px;font-family:'Poppins',sans-serif;letter-spacing:.40px;color:#0b1033;font-weight:normal;padding-top:16px;padding-bottom:8px;">{{ str_limit(strip_tags($featured->title), $limit = 25, $end = '...') }}</a></h5>
                                        <h4>&#8369;{{ number_format($featured->price) }}</h4>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection