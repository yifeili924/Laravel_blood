@extends('layouts.sample')
@section('pageTitle', 'Multiple Choice & Extended Matching Questions')

@section('content')
@include('partials.status-panel')

	<div class="container">
		<div class="subtitle">
			<span>MCQ</span>
			<span>Question 2 of 3 </span>
		</div>

		<div class="question">
			<p> A 33-year-old woman who is 12 weeks pregnant attends her booking appointment.
				This is her third pregnancy; other than a post-partum haemorrhage of >2500ml due
				to placenta previa, she had no major complications in any of her previous pregnancies.
				She has the same partner for this pregnancy that she had for her previous two pregnancies.
				She has no significant personal or family medical history and is not taking any regular medication.
				The results of some of her investigations are as follows:
			</p>
			<br/>
			<p>
				<table style="width:25%; font-size: 15px; font-weight: 900">
					<tr>
						<td><p>Haemoglobin</p></td>
			<td><p>103 g/l</p></td>
			</tr>
			<tr>
				<td><p>MCV</p></td>
				<td><p>84fl</p></td>
			</tr>
			<tr>
				<td><p>White cell count</p></td>
				<td><p>8.9 x 10<sup>9</sup>/l</p></td>
			</tr>
			<tr>
				<td><p>Platelets</p></td>
				<td><p>114 x 10<sup>9</sup>/l</p></td>
			</tr>
			<tr>
				<td><p>Clauss fibrinogen</p></td>
				<td><p>2.5 g/l</p></td>
			</tr>
			<tr>
				<td><p>Ferritin</p></td>
				<td><p>102 ug/l</p></td>
			</tr>
			<tr>
				<td><p>Creatinine</p></td>
				<td><p>64 mmol/l</p></td>
			</tr>
			</table>
			</p>
			<br />
			<p>
				What further action from the list below should be offered to her at this stage of the pregnancy?
			</p>
			<p>
				Please select ONE of the following options:
			</p>
		</div>

		<div class="row no-padding">
			<div class="mcq-questions">
				<div class="question-list">
					<div class="content-row question-item flexDiv" data-value="0">
						<div class="row-char"> A </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>No further action</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" id="correct" data-value="1">
						<div class="row-char"> B </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Offer oral iron replacement</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" data-value="2">
						<div class="row-char"> C </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Offer parenteral iron replacement</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv"  data-value="3">
						<div class="row-char"> D </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Check vitamin B12 level</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
					<div class="content-row question-item flexDiv" data-value="4">
						<div class="row-char"> E </div>
						<div class="col-separator mcq-ques-list-item"></div>
						<div class="answer-option">
							<span>Predelivery autologous blood deposit</span>
							{{--<span class='ans' data-id="{{ $key }}"></span>--}}
						</div>
					</div>
				</div>

				<div class="menu_box" id="discussion-box" style="display: none;">
					<h3 class="menu_title shadow alter">Discussion</h3>
					<ul class="ref">
						<p>
							The blood results indicate a normocytic anaemia. Anaemia in the first trimester is defined
							as a haemoglobin (Hb) level of <110 g/l. The level of thrombocytopenia is typical of gestational
							thrombocytopenia. The first thing that should be considered is the iron deficiency and oral iron
							replacement should be offered (RCOG green top guidelines, 2015). If there is no demonstrable rise
							in Hb after 2 weeks and compliance has been checked, further tests should be undertaken.
						</p>
						<br>
						<p>
							Women with multiple pregnancies should also have an additional full blood count carried
							out at 20–24 weeks.
						</p>
						<br>
						<p>
							Since ferritin is an acute phase protein, it is often raised in pregnancy and, therefore,
							is not a reliable marker of iron deficiency.
						</p>
						<br>
						<p>
							Definitions for anaemia later in pregnancy are:
						<ul>
							<li>Second/third trimester - Hb <105 g/l</li>
							<li>Postpartum - Hb <100 g/l</li>
						</ul>
						</p>
						<br>
						<p>
							Vitamin B12 levels are usually spuriously low due to a reduction in binding proteins
							but no reduction in the active form, holotranscobalamin. If vitamin B12 deficiency is suspected,
							then further specialist tests and/or a trial of empirical hydroxycobalamin should be considered.
						</p>
					</ul>
				</div>

				<div class="menu_box" id="ref-box" style="display: none">
					<h3 class="menu_title shadow alter">Reference</h3>
					<ul class="ref">
						<p>
							Green-top Guideline. "Blood Transfusion in Obstetrics. (2015). <a target="_blank"
																							  href="https://www.rcog.org.uk/globalassets/documents/guidelines/gtg-47.pdf" style="color: blue">Link</a>
						</p>
						<br>
						<p>
							Morkbak, A. L. et al. (2007). Holotranscobalamin remains unchanged during pregnancy.
							Longitudinal changes of cobalamins and their binding proteins during pregnancy and postpartum.
							Haematologica, 92(12), 1711-1712 <a target="_blank"
																href="https://www.ncbi.nlm.nih.gov/pubmed/18056000" style="color: blue">Link</a>
						</p>
					</ul>
				</div>
				<div class="row no-padding">
					<button class="link-primary" type="button" name="submit" id="current" disabled="" style="float: left; margin-right: 15px; margin-top: 0" onclick="showans()">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
					<a href="{{route('public.sample-mcq-emq3')}}" class="link-primary" name="next" id="next" style="float: left; margin-right: 15px" >Next &nbsp;<i class="fa fa-angle-double-right"></i></a>
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
