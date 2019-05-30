@extends('layouts.user-page')
@section('pageTitle', 'Essay')

@section('content')
	@include('partials.status-panel')

	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Essay
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
                <?php echo base64_decode($result->topic); ?>
			</div>

			{!! Form::open(['url' => route('user.essay-ques-page'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}

			<div class="question fw">
                <p><?php echo  base64_decode($result->question); ?></p>
			</div>

			<div class="row no-padding">
				<div class="question-list">
					<div class="content-row">
						<h4>Your Answer</h4>
						<textarea cols="70" rows="8" name="answer"></textarea>
					</div>
				</div>

				<div class="btns">
					<input type="hidden" name="index" value="{{$index}}">
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="qid" value="{{$result->id}}">

					<button class="link-primary" name="submit" value="submit">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
					<button class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="essay">Feedback</button>
				</div>
			</div>
			{!! Form::close() !!}

		</div>

		{{--{!! Form::open(['url' => route('user.submitcomment'), 'data-parsley-validate' ] ) !!}--}}
		{{--<div class="form-group">--}}
			{{--<input type="hidden" name="questionId" value="{{$result->id}}">--}}
			{{--<input type="hidden" name="questionType" value="essay">--}}
			{{--<label for="exampleInputEmail1">Your comments or question</label>--}}
			{{--<textarea name="comment" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>--}}
		{{--</div>--}}
		{{--<button type="submit" class="btn btn-primary">Submit</button>--}}
		{{--{!! Form::close() !!}--}}

	</div>
@stop

