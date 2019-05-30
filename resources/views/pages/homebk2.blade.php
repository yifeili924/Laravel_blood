@include('partials.status-panel')
@extends('layouts.main')

@section('pageTitle', 'Blood Academy')

@section('content')
<!-- <div class="contant_part"> -->
	<!-- banner-part-start-->
	<div class="banner"> <!--<img src="{{ asset('assets/images/logo.png') }}images/banner.jpg" alt=""/> -->

	<div id="JiSlider" class="jislider">
		<ul>
			<li> <img src="{{ asset('assets/images/contctus-bg.jpg') }}" alt=""/></li>
			<li> <img src="{{ asset('assets/images/banner.jpg') }}" alt=""/></li>

		</ul>
	</div>
</div>
<!-- banner-part-end-->
<div class="blood_academy_section">
	<div class="container">
		<div  class="blood_acdmy wp100 center_dev padding_tp-botm">
			<h2>Coming <span>Soon</span></h2>


		</div>
	</div>
</div>
		<!-- </div> -->
		@stop
