<footer class="footer_area">
		<div class="container">
			<div class="footer_widgets">
				<div class="row">
					<div class="col-lg-5 col-md-4 col-6">
						<aside class="f_widget f_about_widget">
							<img src="{{ URL::asset('assets/frontend/img/logo.png') }}" alt="">
							<p>Ang Motorcycle Shop ng Bayan.</p>
							<h6>Social:</h6>
							<ul>
								<li><a href="#"><i class="social_facebook"></i></a></li>
								<li><a href="#"><i class="social_twitter"></i></a></li>
							</ul>
						</aside>
					</div>
					<div class="col-lg-2 col-md-4 col-6">
						<aside class="f_widget link_widget f_info_widget">
							<div class="f_w_title">
								<h3>Information</h3>
							</div>
							<ul>
								<li><a href="#">About us</a></li>
								<li><a href="#">Terms & Conditions</a></li>
							</ul>
						</aside>
					</div>
					<div class="col-lg-2 col-md-4 col-6">
						<aside class="f_widget link_widget f_service_widget">
							<div class="f_w_title">
								<h3>Brands</h3>
							</div>
							<ul>
								<li><a href="#">Honda</a></li>
								<li><a href="#">Yamaha</a></li>
								<li><a href="#">Suzuki</a></li>
								<li><a href="#">Kawasaki</a></li>
							</ul>
						</aside>
					</div>
					<div class="col-lg-2 col-md-4 col-6">
						<aside class="f_widget link_widget f_account_widget">
							<div class="f_w_title">
								<h3>My Account</h3>
							</div>
							<ul>
								<li><a href="{{ url('/dashboard') }}">My account</a></li>
							</ul>
						</aside>
					</div>
				</div>
			</div>
			<div class="footer_copyright">
				<h5>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					&copy; {{ date('Y') }} - All Rights Reserved. | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
				</h5>
			</div>
		</div>
	</footer>