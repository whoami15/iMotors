<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ URL::asset('assets/backend/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">iMotors</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				@if(Auth::user()->role == 1)
				<li class="nav-item">
					<a href="{{ url('/dashboard') }}" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-clipboard-list"></i>
						<p>
							Applications
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('/application') }}" class="nav-link active">
								<i class="far fa-circle nav-icon"></i>
								<p>Apply</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/application/history') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>List</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-money-bill-alt"></i>
						<p>
							Payments
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('/loans') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pay Loans Here</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/payments') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Payment History</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Due</p>
							</a>
						</li>
					</ul>
				</li>
				@elseif(Auth::user()->role == 2)
				<li class="nav-item">
					<a href="{{ url('/admin') }}" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/admin/applications') }}" class="nav-link">
						<i class="nav-icon fas fa-clipboard-list"></i>
						<p>
							Applications
						</p>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-box-open"></i>
						<p>
							Products
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('/admin/products/add') }}" class="nav-link active">
								<i class="far fa-circle nav-icon"></i>
								<p>Add</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/admin/products') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>List</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-money-bill-alt"></i>
						<p>
							Payments
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('/admin/payments') }}" class="nav-link active">
								<i class="far fa-circle nav-icon"></i>
								<p>Payment History</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Due</p>
							</a>
						</li>
					</ul>
				</li>
				@elseif(Auth::user()->role == 3)
				<li class="nav-item">
					<a href="{{ url('/subadmin') }}" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('/') }}" class="nav-link">
						<i class="nav-icon fas fa-clipboard-list"></i>
						<p>
							Applications
						</p>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-money-bill-alt"></i>
						<p>
							Payments
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('/') }}" class="nav-link active">
								<i class="far fa-circle nav-icon"></i>
								<p>Paid</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('/') }}" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Due</p>
							</a>
						</li>
					</ul>
				</li>
				@endif
            </ul>
        </nav>
    </div>
</aside>