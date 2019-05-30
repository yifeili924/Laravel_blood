@extends('layouts.user-page')
@section('pageTitle', 'Laboratory quality assurance')

@section('content')
	@include('partials.status-panel')

    <?php
    $options = array();
    if($result->data) {
        $options = unserialize(base64_decode($result->data));
    }
    ?>

	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Quality Assurance
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
                <?php echo base64_decode($result->topic); ?>
			</div>

			{!! Form::open(['url' => route('user.quality-assurance-page'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}

			<div class="row no-padding">
				@foreach($options as $ky => $opt)
					<div class="question-list">
						<div class="question">
							<span>Question {{$ky + 1}}</span>
							<span><?php echo $opt[0]; ?></span>
						</div>
						<div class="content-row">
							<h4>Your Answer</h4>
							<textarea cols="70" rows="8" name="answer"></textarea>
						</div>
					</div>
				@endforeach

				<div class="btns">
					<input type="hidden" name="index" value="{{$index}}">
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="qid" value="{{$result->id}}">

					<button class="link-primary" name="submit" value="submit" style="margin-right: 15px">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
					<a class="link-primary" href="{{route('subscription.exam-quality-assurance' )}}">Return</a>
					<button class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="quality">Feedback</button>
				</div>
			</div>
			{!! Form::close() !!}

		</div>

		{{--{!! Form::open(['url' => route('user.submitcomment'), 'data-parsley-validate' ] ) !!}--}}
		{{--<div class="form-group">--}}
			{{--<input type="hidden" name="questionId" value="{{$result->id}}">--}}
			{{--<input type="hidden" name="questionType" value="quality-assurance">--}}
			{{--<label for="exampleInputEmail1">Your comments or question</label>--}}
			{{--<textarea name="comment" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>--}}
		{{--</div>--}}
		{{--<button type="submit" class="btn btn-primary">Submit</button>--}}
		{{--{!! Form::close() !!}--}}

	</div>
@stop
