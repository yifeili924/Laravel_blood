@extends('layouts.main')

@section('pageTitle', 'Home')

@section('content')
	@if (session('message'))
		<script type="text/javascript">
			$(document).ready(function () {
				$('#logModal').modal('show');
			});
		</script>
	@endif

	@if (session()->has('errors'))
		<script type="text/javascript">
			$(document).ready(function () {
				$('#signModal').modal('show');
			});
		</script>
	@endif

	<div class="intro_section">
		<div class="cookie_section">
			<span class="cookie_consent">
				This website uses cookies to ensure you get the best experience.
				<a href="/cookies-policy">
					Learn more
				</a>
			</span>
			<div class="compliance">
				<a aria-label="dismiss cookie message" href="#" role="button" tabindex="0" class="cookie_btn cookie_dismiss">
					Got it!
				</a>
			</div>
		</div>
		<div class="container">
			<div class="intro-caption">
				<p>
					<b>Start learning today</b>
					<small>For all your laboratory and clinical haematology learning needs.</small>
				</p>
				<div class="text-center">
					<button class="btn-sign" data-toggle="modal" data-target="#signModal">Sign up</button>
					<button class="btn-login" data-toggle="modal" data-target="#logModal">Login</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="intro-video">
						<iframe src="https://www.youtube.com/embed/EAlQZf3Qe1U" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>
				<div class="col-md-6">
					<div id="newCarousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<div class="item active">
								<img src="{{ asset('assets/images/1.png') }}" alt="New Website Design">
							</div>
							<div class="item">
								<img src="{{ asset('assets/images/2.png') }}" alt="New Content">
							</div>
							<div class="item">
								<img src="{{ asset('assets/images/3.png') }}" alt="Track Your Progress">
							</div>
							<div class="item">
								<img src="{{ asset('assets/images/4.png') }}" alt="Free Trial">
							</div>
							<div class="item">
								<img src="{{ asset('assets/images/5.png') }}" alt="Join Our Community">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<img class="plant" src="{{ asset('assets/images/plant.png') }}">
	</div>
	<div class="question-section">
		<p class="container">Helping you learn and continue learning in haematology. An excellent tool for continued professional
			development and helping you pass the FRCPath haematology exams.</p>
	</div>
	<div class="academy_section">
		<div class="container">
			<p class="description">Aimed at haematologists and biomedical scientists, Blood Academy is a unique and interactive e-learning website.</p>
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xm-6 link-icon">
					<img src="{{ asset('assets/images/explore_icon.png') }}">
					<p class="caption">Explore</p>
					<a href="#feature">More &nbsp;<i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="col-md-3 col-sm-6 col-xm-6 link-icon">
					<img src="{{ asset('assets/images/pricing_icon.png') }}">
					<p class="caption">Pricing</p>
					<a href="#price">More &nbsp;<i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="col-md-3 col-sm-6 col-xm-6 link-icon">
					<img src="{{ asset('assets/images/sign_icon.png') }}">
					<p class="caption">Register </p>
					<a href="" data-toggle="modal" data-target="#signModal" >More &nbsp;<i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="col-md-3 col-sm-6 col-xm-6 link-icon">
					<img src="{{ asset('assets/images/question_icon.png') }}">
					<p class="caption">Sample Questions</p>
					<a href="{{ route('public.samples') }}">More &nbsp;<i class="fa fa-angle-double-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="quote_section">
		<div class="container">
			<h1 class="title">What our users say about Blood Academy…</h1>
			<div id="reviewCarousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active">
						<p class="quote"><em>“The explanations and references were really useful”</em></p>
					</div>

					<div class="item">
						<p class="quote"><em>"A fantastic resource for the FRCPath haematology exam"</em></p>
					</div>

					<div class="item">
						<p class="quote"><em>"Excellent website"</em></p>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="feature_section" id="feature">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Extensive Resource Database</p>
							<p class="description">For both part 1 and 2 FRCPath haematology exams</p>
						</div>
					</div>
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Part 1</p>
							<p class="description">8 new essay questions every 6 months published with our existing essays. Over 200 multiple choice and extended matching questions</p>
						</div>
					</div>
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Part 2</p>
							<p class="description">Covering transfusion medicine, haemostasis and coagulation, morphology and laboratory quality assurance</p>
						</div>
					</div>
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Fortnightly case</p>
							<p class="description">Interactive clinical case with individualised feedback reports</p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Resource Hub</p>
							<p class="description">A collection of summary tables, morphology cases, guideline summaries and interactive modules</p>
						</div>
					</div>
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Self assess and compare your answers</p>
							<p class="description">Fully referenced detailed explanations with model answers in parallel to your own to identify areas of improvement</p>
						</div>
					</div>
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">Track your progress</p>
							<p class="description">Indexed cases allowing you to return to specific questions. Compare your answers to others for MCQ and EMQs</p>
						</div>
					</div>
					<div class="feature_item">
						<img class="check-mark" src="{{ asset('assets/images/check-mark.png') }}">
						<div>
							<p class="caption">E-learning modules</p>
							<p class="description">Covering the essentials of haematology</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="pricing_section" id="price">
		<div class="container px-50">
			<p class="title">Pricing</p>
			<p class="description">Blood-Academy aims to be the most comprehensive revision resource available.
				We are constantly working on developing more content and because we are online we can be much more up-to-date than any written text.
			</p>
			<div class="rows">
				<div class="col-md-6 col-md-offset-3">
					<div class="price-table">
						<p class="price"></p>
						<p class="period">FREE 6 weeks access<sup>*</sup></p>
						<ul class="plans">
							<li class="plan">Fortnightly interactive cases with individualised reports for continued professional development</li>
							<li>Interactive e-learning modules</li>
							<li>Innovative morphology learning experience</li>
						</ul>
						<p>Ends 12/4/2019</p>
						<a href="" class="sign-link" data-toggle="modal" data-target="#signModal">Sign up Now</a>
					</div>
				</div>
				<div class="col-md-6">
					<div class="price-table">
						<p class="price">£80</p>
						<p class="period">4 months access</p>
						<ul class="plans">
							<li class="plan">Unlimited acess to all questions covering both </li>
							<li class="plan">FRCpath (haematology) part 1 and 2 exams</li>
							<li class="plan">Interactive e-learning modules</li>
							<li class="plan">Innovative morphology learning experience</li>
							<li class="plan">Detailed clinical explanations</li>
							<li class="plan">Fortnightly interactive cases with individualised reports for continued professional development</li>
						</ul>
						<a href="" class="sign-link" data-toggle="modal" data-target="#signModal">Sign up Now</a>
					</div>
				</div>
				<div class="col-md-6">
					<div class="price-table">
						<p class="price">£60</p>
						<p class="period">2 months access</p>
						<ul class="plans">
							<li>Unlimited acess to all questions covering both </li>
							<li>FRCpath (haematology) part 1 and 2 exams</li>
							<li>Interactive e-learning modules</li>
							<li>Innovative morphology learning experience</li>
							<li>Detailed clinical explanations</li>
							<li class="plan">Fortnightly interactive cases with individualised reports for continued professional development</li>
						</ul>
						<a href="" class="sign-link" data-toggle="modal" data-target="#signModal">Sign up Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="question-section">
		<div class="container">
			<h2>Interested in institutional access for your students and staff?</h2>
			<p>Contact us for further details and plans.</p>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$(".cookie_btn ").click(function () {
				$(".cookie_section").fadeOut();
			})
		});
	</script>
	<!-- </div> -->
	@stop
