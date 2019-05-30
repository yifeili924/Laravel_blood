@extends('layouts.user-page')
@section('pageTitle', 'Transfusion')

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
				Transfusion
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
                <?php echo base64_decode($result->qcase);?>
			</div>

			<div class="question fw">
                <?php echo base64_decode($result->information);?>
			</div>

			<div class="row no-padding">
				<div class="morp-questions">
					@foreach($options as $ky=>$opt)
						<div class="question-list">
							<div class="question">
								<span>{{$loop->index + 1}}:</span>
								<span><?php echo $opt[0]; ?></span>
							</div>
							<div class="content-row">
								<h4>Your Answer</h4>
								<div class="answer-box">
                                    <?php echo $ans[$ky][0]; ?>
								</div>
							</div>
							<div class="content-row">
								<h4>Model Answer</h4>
								<div class="answer-box">
                                    <?php echo $opt[1]; ?>
								</div>
							</div>
						</div>
					@endforeach

					@if(!empty($result->discussion))
						<div class="menu_box" id="discussion-box">
							<h3 class="menu_title shadow alter">Discussion</h3>
							<ul class="ref">
                                <?php echo base64_decode($result->discussion);?>
							</ul>
						</div>
					@endif

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
				</div>

				{!! Form::open(['url' => route('user.transfusion-page-next'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}
				<div class="morp-actions">
					<div class="btns">

						<input type="hidden" name="index" value="{{$index + 1}}">
						<input type="hidden" name="dt" value="{{$dt}}">
						<input type="hidden" name="qid" value="{{$result->id}}">
						<input type="hidden" name="noques" value="{{$noques}}">
						<input type="hidden" name="ans_after" value="{{$ans_after}}">

						<button class="link-primary" name="sub" value="Next">Next &nbsp;<i class="fa fa-angle-double-right"></i></button>
						<button class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="transfusion-ans">Feedback</button>
					</div>
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

