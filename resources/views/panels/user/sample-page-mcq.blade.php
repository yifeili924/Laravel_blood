@extends('layouts.sample')
@section('pageTitle', 'Multiple Choice & Extended Matching Questions')

@section('content')
@include('partials.status-panel')
	<div class="container">
		<div class="subtitle">
			<span>MCQ</span>
			<span>Question 1 of 3 </span>
		</div>

		<div class="question">
			<p> Which one of the following transfusion complications does leucodepletion of red cells and platelets not protect against?
				Please select ONE of the following options:
			</p>
		</div>

		<div class="row no-padding">
			<div class="mcq-questions">
				<div class="question-list">
					<div class="content-row question-item flexDiv" data-value="0">
						<div class="row-char"> A </div>
						<div class="col-separator mcq-ques-list-item" ></div>
						<div class="answer-option">
							<span>HLA alloimmunisation</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" data-value="1">
						<div class="row-char"> B </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Febrile non-haemolytic transfusion reactions</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" data-value="2">
						<div class="row-char"> C </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Platelet refractoriness </span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" id="correct" data-value="3">
						<div class="row-char"> D </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Transfusion associated graft versus host disease</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" data-value="4">
						<div class="row-char"> E </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Reperfusion injury</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
				</div>

				<div class="menu_box" id="discussion-box" style="display: none;">
					<h3 class="menu_title shadow alter">Discussion</h3>
					<ul class="ref">
						<p>
							Universal leucodepletion was introduced in the UK in 1999, resulting in a reduction in the
							occurrence rates of all the above complications. The incidence of transfusion associated graft
							versus host disease (TA-GvHD) has reduced after this date, however, non-UK based cases of TA-GvHD
							despite the transfusion of leucodepleted blood in susceptible individuals have been reported.
							Therefore, red cell and platelet transfusions should be irradiated, even if leucodepleted.
						</p>
						<br>
						<p>
							The Trial to Reduce Alloimmunization to Platelets (TRAP) study showed a reduction
							in HLA immunisation and platelet refractoriness with leucodepleted platelet transfusions.
						</p>
						<br>
						<p>
							Reperfusion injury occurs within myocardial tissue when there is restoration
							of blood flow to previously ischaemic tissue. In the setting of cardiac surgery,
							leucodepletion has been shown to provide the greatest benefits in morbidity and mortality.
						</p>
					</ul>
				</div>

				<div class="menu_box" id="ref-box" style="display: none">
					<h3 class="menu_title shadow alter">Reference</h3>
					<ul class="ref">
						<p>
							Trial to Reduce Alloimmunization to Platelets Study Group. (1997). Leukocyte reduction and ultraviolet
							B irradiation of platelets to prevent alloimmunization and refractoriness to platelet transfusions.
							N Engl J Med, 1997(337), 1861-1870. <a target="_blank"
																   href="https://www.ncbi.nlm.nih.gov/pubmed/9417523" style="color: blue">Link</a>
						</p>
						<br>
						<p>
							Bilgin, Y. M. et al. (2004). Double-blind, randomized controlled trial on the effect
							of leukocyte-depleted erythrocyte transfusions in cardiac valve surgery. 
							Circulation, 109(22), 2755-2760 <a target="_blank"
															   href="https://www.ncbi.nlm.nih.gov/pubmed/15148271" style="color: blue">Link</a>
						</p>
					</ul>
				</div>
				<div class="row no-padding">
					<button class="link-primary" type="button" name="submit" id="current" disabled="" style="float: left; margin-right: 15px; margin-top: 0" onclick="showans()">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
					<a href="{{route('public.sample-mcq-emq2')}}" class="link-primary" name="next" id="next" style="float: left; margin-right: 15px" >Next &nbsp;<i class="fa fa-angle-double-right"></i></a>
					<a href="{{route('public.samples')}}" class="link-primary" name="next" id="next" style="float: left; margin-right: 15px" >Back to sample questions &nbsp;<i class="fa fa-angle-double-right"></i></a>
				</div>
			</div>
		</div>
	</div>

	<script>
		function selectans(event) {
			document.getElementById("submit").removeAttribute("style");
			document.getElementById("submit").removeAttribute("disabled");
		}
		function showans(event) {
			$('#correct').addClass('correct');
			$('#discussion-box').css("display", "block");
			$('#ref-box').css("display", "block");
			$('#current').css('display', 'none');
		}
	</script>
@stop
