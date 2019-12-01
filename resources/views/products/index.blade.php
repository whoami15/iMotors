@extends('layouts.frontend.master')

@section('title', 'Products')

@section('content')
<section class="categories_banner_area">
    <div class="container">
        <div class="c_banner_inner">
            <h3>Products</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li class="current"><a href="#">Shop</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="categories_product_main p_80">
    <div class="container">
        <div class="categories_main_inner">
            <div class="row row_disable">
                <div class="col-lg-9 float-md-right">
                    <div class="c_product_grid_details">
                        @if($products)
                        @foreach($products as $product)
                        <div class="c_product_item">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="c_product_img">
                                        <img class="img-fluid" src="{{ $product->photos->first()['filename'] }}" alt="{{ $product->title }}">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-6">
                                    <div class="c_product_text">
                                        <h3><a href="{{ url('/product/'.$product->slug) }}" style="font-size:16px;font-family:'Poppins',sans-serif;letter-spacing:.40px;color:#0b1033;font-weight:normal;padding-top:16px;padding-bottom:8px;">{{ str_limit(strip_tags($product->title), $limit = 25, $end = '...') }}</a></h3>
                                        <h5>&#8369;{{ number_format($product->price) }}</h5>
                                        @if($product->stock > 0)
                                        <h6>Available In <span>Stock</span></h6>
                                        @else
                                        <h6>Unavailable <span class="text-danger">Out of Stock</span></h6>
                                        @endif
                                        {{ str_limit(strip_tags($product->description), $limit = 80, $end = '...') }}
                                        <ul class="c_product_btn">
                                            <li><a class="add_cart_btn" href="{{ url('/product/'.$product->slug) }}">View</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <nav aria-label="Page navigation example" class="pagination_area">
                            <ul class="pagination">
                                {{ $products->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3 float-md-right">
                    <div class="categories_sidebar">
                        <aside class="l_widgest l_p_categories_widget">
                            <div class="l_w_title">
                                <h3>Categories</h3>
                            </div>
                            <ul class="navbar-nav">
                                @if($motor_types)
                                @foreach($motor_types as $motor_type)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/shop?type='.strtolower($motor_type->type)) }}">
                                        {{ $motor_type->type }}
                                    </a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </aside>
                        <aside class="l_widgest l_menufacture_widget">
                            <div class="l_w_title">
                                <h3>Manufacturer</h3>
                            </div>
                            <ul>
                                @if($brands)
                                @foreach($brands as $brand)
                                <li><a href="{{ url('/shop?brand='.strtolower($brand->brand_name)) }}">{{ $brand->brand_name }}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </aside>
                        <aside class="l_widgest l_feature_widget">
                            <div class="l_w_title">
                                <h3>Featured Products</h3>
                            </div>
                            @if($featured_products)
                            @foreach($featured_products as $featured)
                            <div class="media">
                                <div class="d-flex">
                                    <img src="{{ $featured->photos->first()['filename'] }}" width="80" height="100" alt="{{ $featured->title }}">
                                </div>
                                <div class="media-body">
                                    <h4><a href="{{ url('/product/'.$featured->slug) }}" style="font-size:16px;font-family:'Poppins',sans-serif;letter-spacing:.40px;color:#0b1033;font-weight:normal;padding-top:16px;padding-bottom:8px;">{{ str_limit(strip_tags($featured->title), $limit = 12, $end = '...') }}</a></h4>
                                    <h5>&#8369;{{ number_format($featured->price) }}</h5>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection