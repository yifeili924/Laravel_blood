@extends('layouts.user-page')
@section('pageTitle', 'Interactive case reports')

@section('content')
	@include('partials.status-panel')
	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Interactive case reports
			</p>
		</div>
		<div class="page-content">
			<div class="clearfix" style="margin-bottom: 20px">
				<a class="link-reset right-floated" data-toggle="modal" data-target="#caseModal">Instructions</a>
			</div>

			<div class="menu_box">
				<div class="tab shadow">
					<button class="tablinks icase active">Current Case</button>
				</div>
				<div class="tablist">
					<div id="myeloid" class="tabcontent tabshow">
						@foreach ($currentcases as $myeloid)
							<a class="icase" href="/user/icasepage/{{$myeloid->id}}">
								<div class="content-row flexDiv">
									<div class="desc-image">
										<img src="/assets/images/interactive.png" alt="Figure Thumbnail">
									</div>
									<div class="col-separator hublist"></div>
									<div class="sample-desc">
										<p><?php echo $myeloid->description ?></p>
									</div>
								</div>
							</a>
						@endforeach
					</div>
				</div>
			</div>

			<div class="menu_box">
				<div class="tab shadow">
					<button class="tablinks icase active">Previous Cases</button>
				</div>
				<div class="tablist">
					<div id="myeloid" class="tabcontent tabshow">
						@foreach ($pastcases as $myeloid)
							<a class="icase" href="/user/icasepage/{{$myeloid->id}}">
								<div class="content-row flexDiv">
									<div class="desc-image">
										<img src="/assets/images/interactive.png" alt="Figure Thumbnail">
									</div>
									<div class="col-separator hublist"></div>
									<div class="sample-desc">
										<p><?php echo $myeloid->description ?></p>
									</div>
								</div>
							</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
