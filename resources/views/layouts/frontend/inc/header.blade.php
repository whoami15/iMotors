<div class="header_top_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="top_header_left">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button"><i class="icon-magnifier"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="top_header_middle">
                    <a href="#"><i class="fa fa-phone"></i> Call Us: <span>0900 000 000</span></a>
                    <a href="#"><i class="fa fa-envelope"></i> Email: <span>contact@imotors.com</span></a>
                    <img src="{{ URL::asset('assets/frontend/img/logo.png') }}" alt="imotors logo">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="top_right_header">
                    <ul class="header_social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                    </ul>
                    <ul class="top_right">
                        <li class="user">
                            @auth
                                @if(Auth::user()->role == 0)
                                <a href="{{ url('/admin') }}"><i class="icon-user icons"></i>
                                @elseif(Auth::user()->role == 1)
                                <a href="{{ url('/dashboard') }}"><i class="icon-user icons"></i>
                                @elseif(Auth::user()->role == 2)
                                <a href="{{ url('/subadmin') }}"><i class="icon-user icons"></i>
                                @endif
                                </a>
                            @else
                                <a href="{{ url('/login') }}"><i class="icon-user icons"></i></a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<header class="shop_header_area">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><img src="{{ URL::asset('assets/frontend/img/logo.png') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav categories">
                    <li class="nav-item">
                        <select class="selectpicker">
                            <option>Categories</option>
                            <option>Categories 2</option>
                            <option>Categories 3</option>
                        </select>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>