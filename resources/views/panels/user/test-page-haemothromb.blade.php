@extends('layouts.user-page')
@section('pageTitle', 'Haemostasis and thrombosis')

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
				Haemostasis and thrombosis
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
				<span>Haemostasis and thrombosis {{$result->id}}: &nbsp;</span>
				<span>{{$index + 1}} of {{$noques}}</span>
                <?php echo base64_decode($result->qcase); ?>
			</div>

			{!! Form::open(['url' => route('user.haemothromb-page'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}

			<div class="question fw">
                <?php echo base64_decode($result->information); ?>
			</div>

			<div class="row no-padding">
				<div class="morp-questions">
					<?php $pos = 1 ?>
					@foreach($options as $ky => $opt)
						<div class="question-list">
							<div class="question">
								<span>Question {{$pos}}</span>
								<span><?php echo $opt[0]; ?></span>
							</div>
							<div class="content-row">
								<h4>Your Answer</h4>
								<textarea cols="70" rows="8" name="ans[{{$ky}}][]"></textarea>
							</div>
						</div>
						<?php $pos++ ?>
					@endforeach

				</div>

				<div class="morp-actions">
					<div class="btns">
						<input type="hidden" name="index" value="{{$index}}">
						<input type="hidden" name="dt" value="{{$dt}}">
						<input type="hidden" name="qid" value="{{$result->id}}">
						<input type="hidden" name="noques" value="{{$noques}}">
						<input type="hidden" name="ans_after" value="{{$ans_after}}">

						<button class="link-primary" name="skip" value="skip" style="margin-right: 15px">Skip &nbsp;<i class="fa fa-angle-double-right"></i></button>
						<button class="link-primary" name="submit" value="submit" style="margin-right: 15px">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
                        <?php
                        if($index > 0) {
                            echo "<button class='link-primary' name='previous' value='Previous question'><i class='fa fa-angle-double-right'></i> &nbsp;Previous</button>";
                        }
                        ?>
						<button class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="haemothromb">Feedback</button>
					</div>
				</div>
			</div>
			{!! Form::close() !!}

		</div>

		{{--{!! Form::open(['url' => route('user.submitcomment'), 'data-parsley-validate' ] ) !!}--}}
		{{--<div class="form-group">--}}
			{{--<input type="hidden" name="questionId" value="{{$result->id}}">--}}
			{{--<input type="hidden" name="questionType" value="haemothromb">--}}
			{{--<label for="exampleInputEmail1">Your comments or question</label>--}}
			{{--<textarea name="comment" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>--}}
		{{--</div>--}}
		{{--<button type="submit" class="btn btn-primary">Submit</button>--}}
		{{--{!! Form::close() !!}--}}
	</div>
@stop
