@extends('layouts.user-page')
@section('pageTitle', 'Essay')

@section('content')
	@include('partials.status-panel')
   	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Essays
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
                <?php echo base64_decode($result->topic);?>
			</div>

			<div class="question fw">
                <p><?php echo base64_decode($result->question);?></p>
			</div>

			<div class="row no-padding">
				<div class="question-list">
					<div class="content-row">
						<h4>Your Answer</h4>
						<div class="answer-box">
							<?php echo $answer; ?>
						</div>
					</div>
				</div>

				<div class="question-list">
					<div class="content-row">
						<h4>Model Answer</h4>
						<div class="answer-box">
							<?php echo base64_decode($result->answer); ?>
						</div>
					</div>
				</div>

				<div class="discussionimages">
					<?php
					if(!empty($result->selimages)) {
						$myname =  $result->selimages;
						$imsArray = explode("|", $myname);
						foreach ($imsArray as $imagename) {
							echo "<div style='margin: 5px'><img src=https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "></div>";
						}
					}
					?>
				</div>

				@if(!empty($result->reference))
					<div class="menu_box">
						<h3 class="menu_title shadow alter">Reference</h3>
						<ul class="ref">
							<?php echo base64_decode($result->reference); ?>
						</ul>
					</div>
				@endif

				{!! Form::open(['url' => route('user.morphology-ques-page-next'), 'id'=> 'test_mcq_each', 'data-parsley-validate' ] ) !!}
				<div class="btns">

					<input type="hidden" name="index" value="{{$index}}">
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="qid" value="{{$result->id}}">

					<a class="link-primary" href="{{ route('subscription.exam-essay-questions') }}">Return</a>
					<a class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="essay-ans">Feedback</a>
				</div>
				{!! Form::close() !!}
			</div>
		</div>

	</div>

	{{--{!! Form::open(['url' => route('user.submitcomment'), 'data-parsley-validate' ] ) !!}--}}
	{{--<div class="form-group">--}}
	{{--<input type="hidden" name="questionId" value="{{$result->id}}">--}}
	{{--<input type="hidden" name="questionType" value="morphology">--}}
	{{--<label for="exampleInputEmail1">Your comments or question</label>--}}
	{{--<textarea name="comment" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>--}}
	{{--</div>--}}
	{{--<button type="submit" class="btn btn-primary">Submit</button>--}}
	{{--{!! Form::close() !!}--}}

@stop

