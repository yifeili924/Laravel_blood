@extends('layouts.user-page')
@section('pageTitle', 'Multiple Choice & Extended Matching Questions')

@section('content')
@include('partials.status-panel')
	<?php
	$options = array();
	if($result->data) {
		$options = unserialize(base64_decode($result->data));
	}

    $list = array('A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7);

    $page_title = '';
    if ($result->type == 'single') {
        $page_title = 'Extended Matching Questions';
    } else {
        $page_title = 'Multiple Choice Questions';
    }
    ?>

	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				<span class="desktop_show">{{ $page_title }}</span>
				<span class="mobile_show">MCQ </span>
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle">
				@if($result->type == 'single')
					<span>EMQ</span>
				@else
					<span>MCQ</span>
				@endif
				<span>{{$result->id}}: &nbsp;</span>
				<span>Question {{$index + 1}} of {{ session('total_ques') }}</span>
			</div>

			{!! Form::open(['url' => route('user.mcq-ques-page'), 'id'=> 'test_mcq_each', 'data-parsley-validate' ] ) !!}

			<div class="question">
                <?php echo base64_decode($result->question); ?>
			</div>

			@if ($result->type == 'single')
				<div class="question-menu-caption shadow">Questions</div>
			@endif

			<div class="row no-padding">
				<div class="status_wrapper">
					<div class="mcq-questions">
						<div class="question-list">
							@if ($result->type == 'single')
								<?php $x = 0; ?>
								@foreach ($options as $key2 => $option)
									<div class="content-row flexDiv">
										<div class="row-char">
											<b>	<?php echo array_search($x, $list); ?>	</b>
										</div>
										<div>
											<?php echo $option[0] ?>
										</div>
									</div>
									<div id="testDiv{{$key2}}" class="content-row flexDiv">
										<div style="margin-right: 50px">
											<span id="testDivSpan{{$key2}}">Answer</span>
										</div>
										<div style="width: 80%">
											<select onchange='selectans()' name="que_ans[{{ $key2 }}]" style="width: 100%">
												<option value=''>Choose from one of the following answers</option>
												@foreach ($option as $key => $opt)
													@if (gettype($opt) == 'array')
														<option value="{{ $key }}">{{ $opt[1] }}</option>
													@endif
												@endforeach
											</select>
											<span class="ans" data-id={{ $key2 }}></span>
										</div>
									</div>
									<?php $x++; ?>
								@endforeach
							@else
								@foreach($options as $key=>$option)
									@if(!empty($option[0]))
										<div id="optionBit" class="content-row question-item flexDiv" data-value="{{ $key }}">
											<div class="row-char">
											<span>
											<?php echo array_search($key, $list); ?>
											</span>
											</div>
											<div class="col-separator mcq-ques-list-item"></div>
											<div class="answer-option">
												<span><?php echo $option[0]; ?></span>
												{{--<span class='ans' data-id="{{ $key }}"></span>--}}
											</div>
										</div>
									@endif
								@endforeach
							@endif
						</div>
					</div>
					<div class="question-actions status_section" style="display: none;">
						<div class="menu_box">
							<h3 class="menu_title shadow">Global question Stats (%)</h3>
							<ul class="ref">
								<canvas id="myChart" height="250"></canvas>
							</ul>
						</div>
					</div>
				</div>
				<div class="status_wrapper">
					<div class="question-actions status_section" style="display: none;">
						<div class="menu_box">
							<h3 class="menu_title shadow">Session Progress</h3>
							<ul class="ref">
								<li>
									<span>Responses correct:</span>
									<span id="totalCorrect" style="float: right;"></span>
								</li>
								<li>
									<span>Responses incorrect</span>
									<span id="totalInCorrect" style="float: right;"></span>
								</li>
								<li>
									<span>Responses correct(%)</span>
									<span id="percentage" style="float: right;"></span>
								</li>
							</ul>
						</div>
					</div>
					<div class="mcq-questions">
					<div class="menu_box" id="discussion-box" style="display: none;">
						<h3 class="menu_title shadow alter">Discussion</h3>
						<ul class="ref">
                            <?php echo base64_decode($result->discussion); ?>
						</ul>
					</div>

					@if(!empty($result->reference))
						<div class="menu_box" id="ref-box" style="display: none">
							<h3 class="menu_title shadow alter">Reference</h3>
							<ul class="ref">
                                <?php echo base64_decode($result->reference); ?>
							</ul>
						</div>
					@endif

					<div class="discussionimages discussion"  style="display: none;">
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

					<div class="row no-padding">
						<button class="link-primary" name="skip" id="skip" style="float: left; margin-right: 15px">Skip &nbsp;<i class="fa fa-angle-double-right"></i></button>
						<button class="link-primary" type="button" name="submit" id="current" disabled="" style="float: left; margin-right: 15px">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
						<button class="link-primary" name="next" id="next" style="display: none; float: left; margin-right: 15px" >Next &nbsp;<i class="fa fa-angle-double-right"></i></button>

                        <?php
                        if($index > 0) {
                            echo "<button class='link-primary' name='previous' value='Previous'><i class='fa fa-angle-double-left'></i> Previous</button>";
                        }
                        ?>

						<button class="link-feedback" data-toggle="modal" data-target="#fbModal" type="button" style="float: right" data-question-id="{{$result->id}}" data-question-type="mcq">Feedback</button>
					</div>
				</div>
				</div>


			</div>

			<input type="hidden" name="que_ans[]" id="selIndex">
			<input type="hidden" name="questype" value="{{$questype}}">
			<input type="hidden" name="qtype" id="qtype" value="{{$result->type}}">
			<input type="hidden" name="dt" id="dt" value="{{$dt}}">
			<input type="hidden" name="index" value="{{$index}}">
			@if($result->type == 'single')
				<input type="hidden" name="questype" value="emqs">
			@else
				<input type="hidden" name="questype" value="mcqs">
			@endif
			<input type="hidden" name="qid" id="qid" value="{{$result->id}}">
			<input type="hidden" name="showans" value="show-ans">

			{!! Form::close() !!}

		</div>

	</div>

	<script>

		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};
		var tot = "{{session('total_ques')}}";

		var crr = (localStorage.getItem("correct") == null) ? 0 : localStorage.getItem("correct");
		var incrr = (localStorage.getItem("incorrect") == null) ? 0 : localStorage.getItem("incorrect");

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						crr,
						incrr,
					],
					backgroundColor: [
						'#008000',
						'#e52828',
					],
					borderColor: [
						'rgba(255,99,132,1)'
					],
					label: 'MCQ-EMQ',
				}],
				labels: [
					"Correct",
					"Incorrect"
				]
			},
			options: {
				legend: { labels: { fontColor:"gray", fontSize: 12 }},
				responsive: true,
				showLines: false
			}
		};

		function selectans(event) {
            document.getElementById("current").removeAttribute("style");
            document.getElementById("current").removeAttribute("disabled");
		}

        $("#current").on('click', function(event) {

            var formData = $("#test_mcq_each").serializeArray();

            $.ajax({

                url: Base_Url + '/checkque',

                type: 'POST',

                dataType: 'json',

                data: formData,

            })
			.done(function(data) {
                	let letters = ["A", "B", "C", "D", "E", "F", "G", "H"];
                	let labels = [];
                	let stats = [];
                	let styleInCorrect= 'rgba(43, 83, 129, 0.7)';
                	let styleCorrect= 'rgba(149, 193, 35, 0.7)';
                	let styles = [];
                    var yes = 0;
                    var no = 0;
                    var yes2 = 0;
                    var no2 = 0;


                    for (let k in data.arr) {
                        if (data.arr[k].value === 'yes') {
                            yes2++;
                            styles.push(styleCorrect);
                            $('#testDiv'+data.arr[k].key).addClass('correct');
                            $('#testDivSpan'+data.arr[k].key).text('CORRECT');
                            $('.question-list .question-item').eq(data.arr[k].key).addClass('correct');
                        }

                        if (data.arr[k].value === 'no') {
                            no2++;
                            styles.push(styleInCorrect);
                            $('#testDiv'+data.arr[k].key).css('color', 'red');
                            $('#testDivSpan'+data.arr[k].key).text('INCORRECT');
                        }

                        if (data.arr[k].key === data.arr[k].uans &&  data.arr[k].value === 'yes') {
                            yes = 1;
                        }

                        if (data.arr[k].key === data.arr[k].uans && data.arr[k].value === 'no') {
                            no = 1;
                        }

                        labels.push(letters[k]);
                        stats.push(data.arr[k].choiceStats);
                    }

                    let total = data.stats.total;
                    let correct = data.stats.totalCorrect;
                    let incorrect = data.stats.totalInCorrect;

                	$('#totalCorrect').text(correct);
                	$('#totalInCorrect').text(incorrect);
                	$('#percentage').text(Math.round((correct/(incorrect + correct) * 100)));



                    $("#current").css('display', 'none');
                    $("#next").css('display', 'block');
                    $("#skip").hide();

                    $( "input[name='skip']" ).css( 'display', 'none');
                    $('#discussion-box').show();
                    $('#ref-box').show();

                    $(".discussion").css('display', 'block');

                    if ($("#qtype").val() == 'single') {

                        var corr = parseInt(yes2) * 100;
                        var ttc = corr / parseInt($("select").length);
                        var finl = parseInt(ttc) / 100;

                        var in_corr = parseInt(no2) * 100;
                        var tt_in = in_corr / parseInt($("select").length);
                        var finl_in = parseInt(tt_in) / 100;

                        if (yes2 > 0) {
                            var crr = (localStorage.getItem("correct") == null) ? 0 : localStorage.getItem("correct");
                            localStorage.setItem("correct", parseFloat(crr) + parseFloat(finl));
                            console.log('yes', yes2, parseFloat(crr) + parseFloat(finl));
                        }

                        if (no2 > 0) {
                            var incrr = (localStorage.getItem("incorrect") == null) ? 0 : localStorage.getItem("incorrect");
                            localStorage.setItem("incorrect", parseFloat(incrr) + parseFloat(finl_in));
                            console.log('no', no2, parseFloat(incrr) + parseFloat(finl_in));
                        }



                    } else {

                        if (yes == 1) {

                            var crr = (localStorage.getItem("correct") == null) ? 0 : localStorage.getItem("correct");

                            localStorage.setItem("correct", parseFloat(crr) + 1);

                        }

                        if (no == 1 && yes == 0) {

                            var incrr = (localStorage.getItem("incorrect") == null) ? 0 : localStorage.getItem("incorrect");

                            localStorage.setItem("incorrect", parseFloat(incrr) + 1);

                        }
                    }

                    showChart(labels, stats, styles);
                })

                .fail(function() {

                    console.log("error");

                })

                .always(function() {

                    console.log("complete");

                });

        });
        function showChart(labels, stats, styles) {
            var ctx = document.getElementById('myChart').getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: stats,
                        backgroundColor: styles,
                        borderColor: styles,
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                stepSize: 50,
                                max: 100,
                                beginAtZero: true
                            },
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{

                        }]
                    }
                }
            });
            $('#stats').show();
            $(".status_section").show();
        }
	</script>
@stop
