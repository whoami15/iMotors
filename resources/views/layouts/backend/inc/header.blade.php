<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#">
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
            </a>
		</li>
		<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
		{!! csrf_field() !!}
		</form>
    </ul>
</nav>