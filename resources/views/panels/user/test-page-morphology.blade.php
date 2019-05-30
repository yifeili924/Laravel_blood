@extends('layouts.user-page')
@section('pageTitle', 'Morphology')

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
				Morphology
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
				@if($q_type == 'short-long')
					<span>Either Short or Long cases</span>
				@endif
				@if($q_type == 'short-cases')
					<span>Short cases</span>
				@endif
				@if($q_type == 'long-cases')
					<span>Long cases</span>
				@endif
				<span>{{$result->id}}: &nbsp;</span>
				<span>Question {{$index + 1}} of {{$noques}}</span>
			</div>

			{!! Form::open(['url' => route('user.morphology-ques-page'), 'id'=> 'test_mcq_each', 'data-parsley-validate' ] ) !!}

			<div class="question fw">
				<?php echo base64_decode($result->information); ?>
			</div>

			<div class="row no-padding">
				<div class="question-list">
					@foreach($options as $ky=>$opt)
						<div class="content-row">
							<h4><?php echo $opt[0]; ?></h4>
							<textarea rows="6" cols="55" name="ans[{{$ky}}][]" placeholder="Answer"></textarea>
						</div>
					@endforeach
				</div>

				<div class="row no-padding img-slider">
					<div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; margin-top: 15px; background: #e7e7e7"></div>
					<div id="openseadragon1" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
				</div>

				<div class="btns">
					<input type="hidden" name="q_type" value="{{$q_type}}">
					<input type="hidden" name="ans_after" value="{{$ans_after}}">
					<input type="hidden" name="noques" value="{{$noques}}">

					<button class="link-primary" name="skip" value="skip" style="float: left; margin-right: 15px">Skip &nbsp;<i class="fa fa-angle-double-right"></i></button>
					<button class="link-primary" name="submit" value="submit" style="float: left; margin-right: 15px">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>

                    <?php
                    if($index > 0) {
                        echo "<button class='link-primary' name='previous' value='Previous'><i class='fa fa-angle-double-left'></i> Previous</button>";
                    }
                    ?>

					<button class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="morphology"> Feedbacks </button>
				</div>
			</div>

			<input type="hidden" name="dt" id="dt" value="{{$dt}}">
			<input type="hidden" name="index" value="{{$index}}">
			<input type="hidden" name="qid" id="qid" value="{{$result->id}}">
			<input type="hidden" name="showans" value="show-ans">

			{!! Form::close() !!}

		</div>

	</div>

	<script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
	<script type="text/javascript">
        $('#openseadragon1').prop('hidden', true);
        $('#toolbardiv').prop('hidden', true);
        <?php
        if(isset($result->slides)) {
            echo "$('#toolbardiv').prop('hidden', false);";
            echo "$('#openseadragon1').prop('hidden', false);";
            echo "var viewer = OpenSeadragon({id: 'openseadragon1', prefixUrl: 'https://s3.eu-central-1.amazonaws.com/simplezoom123/kidz_files/',";
            $finalstring = null;
            $prestring = "'https://s3.eu-west-2.amazonaws.com/";
            $myname =  $result->slides;
            foreach ($result->slides as $slide) {
                $bucketname = $slide->bucket_name;
                $finalname = $slide->name;
                if(isset($finalstring)) {
                    $finalstring  =  $finalstring . $prestring . $bucketname. '/'. $finalname ."',";
                }else {
                    $finalstring  =  $prestring . $bucketname. '/'. $finalname ."',";
                }
            }
            $arraystring = substr($finalstring, 0, strlen($finalstring)-1);
            echo "tileSources: [". $arraystring ."],";
            echo "toolbar: 'toolbardiv', springStiffness:10, sequenceMode:true,showReferenceStrip:true,autoHideControls:false,referenceStripScroll:'vertical'});";
        }
        ?>
	</script>
@stop
