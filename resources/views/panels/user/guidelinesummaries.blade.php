@extends('layouts.user-page')
@section('pageTitle', 'Guideline Summaries')

@section('content')
	@include('partials.status-panel')
	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Guideline Summaries
			</p>
		</div>
		<div class="page-content">
			<div>
				<div class="tab shadow">
					<button class="tablinks firstTab active">Malignant Haematology</button>
					<button class="tablinks secondTab">Haemostasis and Thrombosis</button>
					<button class="tablinks thirdTab">Transfusion</button>
					<button class="tablinks fourthTab">General Haematology</button>
				</div>
				<div class="tablist">
					<div id="mailgnant" class="tabcontent tabshow">
						@foreach ($mals as $index => $mal)
							<a href="{{ route('user.guidelinesummaries', ['fid' => $mal->id])}}" class="icase">
								<div class="content-row flexDiv">
									<div class="desc-image">
										<img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail">
									</div>
									<div class="col-separator hublist"></div>
									<div class="sample-desc">
										<?php echo base64_decode($mal->title); ?>
									</div>
								</div>
							</a>
						@endforeach
					</div>

					<div id="haemostasis" class="tabcontent">
						@foreach ($thrombs as $index => $mal)
							<a href="{{ route('user.guidelinesummaries', ['fid' => $mal->id])}}" class="icase">
								<div class="content-row flexDiv">
									<div class="desc-image">
										<img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail">
									</div>
									<div class="col-separator hublist"></div>
									<div class="sample-desc">
										<?php echo base64_decode($mal->title); ?>
									</div>
								</div>
							</a>
						@endforeach
					</div>

					<div id="transfusion" class="tabcontent">
						@foreach ($trans as $index => $mal)
							<a href="{{ route('user.guidelinesummaries', ['fid' => $mal->id])}}" class="icase">
								<div class="content-row flexDiv">
									<div class="desc-image">
										<img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail">
									</div>
									<div class="col-separator hublist"></div>
									<div class="sample-desc">
										<?php echo base64_decode($mal->title); ?>
									</div>
								</div>
							</a>
						@endforeach
					</div>

					<div id="general-haematology" class="tabcontent">
						@foreach ($generals as $index => $mal)
							<a href="{{ route('user.guidelinesummaries', ['fid' => $mal->id])}}" class="icase">
								<div class="content-row flexDiv">
									<div class="desc-image">
										<img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail">
									</div>
									<div class="col-separator hublist"></div>
									<div class="sample-desc">
										<?php echo base64_decode($mal->title); ?>
									</div>
								</div>
							</a>
						@endforeach
					</div>

				</div>
			</div>

			<div class="clearfix"></div>
		</div>
	</div>
@stop
