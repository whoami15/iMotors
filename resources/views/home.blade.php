@extends('layouts.frontend.master')

@section('title', 'Home')

@section('content')
<section class="our_latest_product">
    <div class="container">
        <div class="s_m_title">
            <h2>Our Latest Product</h2>
        </div>
        <div class="l_product_slider owl-carousel">
            <div class="item">
                <div class="l_product_item">
                    <div class="l_p_img">
                        <img src="{{ URL::asset('assets/frontend/img/product/l-product-1.jpg') }}" alt="">
                    </div>
                    <div class="l_p_text">
                        <ul>
                            <li><a class="add_cart_btn" href="#">View</a></li>
                        </ul>
                        <h4>Womens Libero</h4>
                        <h5>&#8369;{{ number_format(10000) }}</h5>
                    </div>
                </div>
            </div>
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
                        <a class="add_btn" href="#">Shop Now <i class="arrow_right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="f_add_item white_add">
                    <div class="f_add_img"><img class="img-fluid" src="{{ URL::asset('assets/frontend/img/feature-add/f-add-5.jpg') }}" alt=""></div>
                    <div class="f_add_hover">
                        <h4>Best Summer <br />Collection</h4>
                        <a class="add_btn" href="#">Shop Now <i class="arrow_right"></i></a>
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
                                <li><a href="#">get motor by type limit 5</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <div class="p_list_img">
                            <img src="{{ URL::asset('assets/frontend/img/product/p-categories-list/product-l-1.jpg') }}" alt="">
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
                                <li><a href="#">get motor by type limit 5</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <div class="p_list_img">
                            <img src="{{ URL::asset('assets/frontend/img/product/p-categories-list/product-l-2.jpg') }}" alt="">
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
                                <li><a href="#">get motor by type limit 5</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <div class="p_list_img">
                            <img src="{{ URL::asset('assets/frontend/img/product/p-categories-list/product-l-3.jpg') }}" alt="">
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
                                    <img src="{{ URL::asset('assets/frontend/img/product/featured-product/f-p-1.jpg') }}" alt="">
                                </div>
                                <div class="media-body">
                                    <h4>Honda/Yamaha</h4>
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
                            <div class="item">
                                <div class="fillter_product_item">
                                    <div class="f_p_img">
                                        <img src="{{ URL::asset('assets/frontend/img/product/fillter-product/f-product-1.jpg') }}" alt="">
                                    </div>
                                    <div class="f_p_text">
                                        <h5>Nike Max Air Vapor Power</h5>
                                        <h4>&#8369;{{ number_format(10000) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection