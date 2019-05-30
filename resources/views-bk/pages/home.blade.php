@extends('layouts.main')
@section('content')
@include('partials.status-panel')
<!-- <div class="contant_part"> -->
	<!-- banner-part-start-->
	<div class="banner"> <!--<img src="{{ asset('assets/images/logo.png') }}images/banner.jpg" alt=""/> -->
	
	<div id="JiSlider" class="jislider">
		<ul>
			{{--<li> <img src="{{ asset('assets/images/contctus-bg.jpg') }}" alt=""/></li>--}}
			<li> <img src="{{ asset('assets/images/newbanner.jpg') }}" alt=""/></li>
			
		</ul>
	</div>
</div>
<!-- banner-part-end-->
<div class="blood_academy_section">
	<div class="container">
		<div  class="blood_acdmy wp100 center_dev padding_tp-botm">
			<h2>Blood<span>Academy</span></h2>
			<span>An interactive revision tool to maximise your success in  the <br>
			FRCPath haematology exams</span>
			<div class="row_acdmy wp100 padding_top">
				<div class="asdmy_box">
					<div class="blod_box">
						<div class="icon_bld"><img src="{{ asset('assets/images/explore.png') }}" alt=""/> </div>
						<h4>Explore</h4>
						<p>Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of </p>
						<a href="#">More Info <i class="fa fa-chevron-right" aria-hidden="true"></i> </a> </div>
					</div>
					<div class="asdmy_box">
						<div class="blod_box">
							<div class="icon_bld"><img src="{{ asset('assets/images/pricing.png') }}" alt=""/> </div>
							<h4>Pricing</h4>
							<p>Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of </p>
							<a href="#">More Info <i class="fa fa-chevron-right" aria-hidden="true"></i> </a> </div>
						</div>
						<div class="asdmy_box">
							<div class="blod_box">
								<div class="icon_bld"><img src="{{ asset('assets/images/login.png') }}" alt=""/> </div>
								<h4>Log in/Register</h4>
								<p>Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of </p>
								<a href="#">More Info <i class="fa fa-chevron-right" aria-hidden="true"></i> </a> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="about_section">
				<div class="container">
					<div class="blood-academy-about wp100">
						<!--<div class="about_left">
								<div class="bg_img"><img src="{{ asset('assets/images/logo.png') }}images/about.jpg" alt=""/></div>
						</div>-->
						
						<div class="right_about wp100 center_dev">
							<h2>About<span>us</span></h2>
							<p>Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of passing the Fellowship of the Royal College of Pathologists (FRCPath) haematology exam. We are based in the UK and all content is provided by haematologists and scientists who have passed the exam.</p>
							<p>
							There is obviously no substitute to a well-structured training scheme. However, getting exposure to rare cases as well as developing and refining exam technique can be difficult. This site aims to </p>
							<a href="#" class="btn_red"><span>Read more </span><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="contact_section">
				<div class="container">
					<div class="con_tant wp100">
						<div class="cont_from">
							<h2 align="center">Contact<span>Us</span></h2>
							<p>Our Company is the best, meet the creative team that never sleeps. Say something to us we will answer to you.</p>
							
							<form>
								<input type="text" name="" value="" placeholder="Name">
								<input type="text" name="" value="" placeholder="Email">
								<input type="text" name="" value="" placeholder="Phone number">
								<textarea placeholder="Message"></textarea>
								<input type="submit" name="" value="Send message">
								
							</form>
						</div>
					</div>
				</div>
			</div>
		<!-- </div> -->
		@stop