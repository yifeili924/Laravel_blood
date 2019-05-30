@extends('layouts.user-page')
@section('pageTitle', 'Haemostasis and thrombosis - Options')

@section('content')
	@include('partials.status-panel')
	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Haemostasis and Thrombosis
			</p>
		</div>
		<div class="page-content">
			<p class="subtitle">Use the information tab to get quick tips</p>
			<div>
				<div class="tab shadow">
					<button class="tablinks firstTab">Questions</button>
					<button class="tablinks secondTab">Information</button>
				</div>
				<div class="tablist">
					<div id="questions" class="tabcontent tabshow">
						{!! Form::open(['url' => route('user.get-haemothromb-ques'), 'data-parsley-validate' ] ) !!}

						<div class="content-row">
							<span class="row-label">Questions I have</span>
							<div class="row-data">
								<label class="checkcontainer">Seen before
									<input checked type="radio" name="q-seen" value="seen">
									<span class="radiomark"></span>
								</label>
								<label class="checkcontainer">Not seen before
									<input type="radio" name="q-seen" value="not_seen" checked>
									<span class="radiomark"></span>
								</label>
							</div>
						</div>
						<div class="content-row">
							<span class="row-label">Number of Questions</span>
							<div class="row-data">
								<select name="questions">
									<!-- <option value="">-Select Options-</option> -->
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option>
									<option value="50">50</option>
									<option value="all">All</option>
								</select>
							</div>
						</div>

						<div class="content-row">
							<button type="submit" class="link-primary" name="sub">Start &nbsp;<i class="fa fa-angle-double-right"></i></button>
						</div>
						{!! Form::close() !!}
					</div>

					<div id="information" class="tabcontent info-tab boxize">
						<div class="content-row">
							<p><?php echo base64_decode($haemoInfo); ?></p>
						</div>
					</div>
				</div>

				<div class="flash-message">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
						@if(Session::has('alert-' . $msg))
							<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
						@endif
					@endforeach
				</div> <!-- end .flash-message -->
			</div>

			<div class="clearfix"></div>
		</div>
	</div>
@stop

