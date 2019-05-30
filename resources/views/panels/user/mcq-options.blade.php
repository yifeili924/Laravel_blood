@extends('layouts.user-page')
@section('pageTitle', 'MCQs, EMQs - Options')

@section('content')
	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
			 	<span class="desktop_show">Multiple Choice and Extended Matching Questions</span>
				<span class="mobile_show">MCQ/EMQ </span>
			</p>
		</div>
		<div class="page-content">
			<p class="subtitle">Use the information tab to get quick tips</p>
			<div>
				<div class="tab shadow">
					<button class="tablinks firstTab active">Questions</button>
					<button class="tablinks secondTab">Information</button>
				</div>
				<div class="tablist">
					<div id="questions" class="tabcontent tabshow">
						{!! Form::open(['url' => route('user.get-mcq-ques'), 'data-parsley-validate' ] ) !!}
						<div class="content-row">
							<span class="row-label">Question type</span>
							<div class="row-data">
								<label class="checkcontainer">MCQs
									<input type="radio" name="ques-type" value="mcqs" checked>
									<span class="radiomark"></span>
								</label>
								<label class="checkcontainer">EMQs
									<input type="radio" name="ques-type" value="emqs">
									<span class="radiomark"></span>
								</label>
								<label class="checkcontainer">MCQs and EMQs
									<input type="radio" name="ques-type" value="mcqs-emqs">
									<span class="radiomark"></span>
								</label>
							</div>
						</div>
						<div class="content-row">
							<span class="row-label">Question type</span>
							<div class="row-data">
								<label class="checkcontainer">Seen before
									<input checked type="radio" name="ques-seen" value="seen">
									<span class="radiomark"></span>
								</label>
								<label class="checkcontainer">Not seen before
									<input type="radio" name="ques-seen" value="not_seen" checked>
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
							<span class="row-label">Subject</span>
							<div class="row-data mcq_rows">
								<label class="checkcontainer first_title">Select all
									<input type="checkbox" id="check_all">
									<span class="checkmark"></span>
								</label>
								<label class="checkcontainer">General haematology
									<input type="checkbox" checked class="subject" name="subject[]" value="general-haematology">
									<span class="checkmark"></span>
								</label>
								<label class="checkcontainer">Transfusion
									<input type="checkbox" class="subject" name="subject[]" value="transfusion">
									<span class="checkmark"></span>
								</label>
								<label class="checkcontainer">Haemato-oncology
									<input type="checkbox" class="subject" name="subject[]" value="haemato-oncology">
									<span class="checkmark"></span>
								</label>
								<label class="checkcontainer">Haemastasis and thrombosis
									<input type="checkbox" class="subject" name="subject[]" value="haemastasis-thrombosis">
									<span class="checkmark"></span>
								</label>
							</div>
						</div>
						<div class="content-row">
							<button type="submit" class="link-primary">Start &nbsp;<i class="fa fa-angle-double-right"></i></button>
						</div>
						{!! Form::close() !!}
					</div>

					<div id="information" class="tabcontent boxize">
						<div class="content-row">
							<?php echo base64_decode($mcq_emq); ?>
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

<script type="text/javascript">
	localStorage.removeItem('correct');
    localStorage.removeItem('incorrect');
    localStorage.removeItem('perc');
</script>
@stop
