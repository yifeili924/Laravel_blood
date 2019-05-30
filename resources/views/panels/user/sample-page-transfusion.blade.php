
@extends('layouts.sample')
@section('pageTitle', 'Transfusion')

@section('content')
@include('partials.status-panel')

	<style>
		.hideit { display: none; }
	</style>

	<div class="container">
		<div class="subtitle">
			<span>Sample Transfusion Case</span>
		</div>

		<div class="question fw">
			<p>
				A 62-year-old man attends the transplant clinic to discuss an autologous stem cell
				transplant for the treatment of his multiple myeloma in first remission. He has a
				history of hypertension and diabetes mellitus but apart from presenting with mild renal
				impairment at diagnosis he has tolerated bortezomib-based induction therapy well.
			</p>
		</div>

		<div class="row no-padding">
			<div class="question-list">
				<h4 style="color: white; margin-bottom: 15px;"><p>1) What patient factors are associated with a poor stem cell yield ? </p></h4>
				<div class="content-row">
					<h4>Your Answer</h4>
					<textarea rows="6" cols="55" placeholder="Answer"></textarea>
				</div>
			</div>
			<div class="question-list hideit" id="model1">
				<div class="content-row">
					<h4>Model Answer</h4>
					<div class="answer-box">
						Risk factors for poor yield <br>
						* Low circulating CD34+ cells <br>
						* Previous extensive chemotherapy <br>
						* Radiation therapy <br>
						* Previous mobilisation failure <br>
						* Advanced age <br>
						* Treatment with purine analogue and lenalidomide <br>
					</div>
				</div>
			</div>

			<div class="question-list">
				<h4 style="color: white; margin-bottom: 15px;"><p>2) What are risks associated with the stem cell harvest procedure?</p></h4>
				<div class="content-row">
					<h4>Your Answer</h4>
					<textarea rows="6" cols="55" placeholder="Answer"></textarea>
				</div>
			</div>
			<div class="question-list hideit" id="model2">
				<div class="content-row">
					<h4>Model Answer</h4>
					<div class="answer-box">
						Risks associated with stem cell harvest procedure <br>
						* Haemodynamic instability <br>
						* Citrate toxicity resulting in hypocalcaemia (paraesthesia,
						tetany, rarely arrhythmia) <br>
						* Complications arising from central venous access if peripheral access not
						possible (haemorrhage, pneumothorax, infection) <br>
						* G-CSF toxicity – musculoskeletal pain, splenic rupture if
						pre-existing massive splenomegaly <br>
					</div>
				</div>
			</div>

			<div class="question-list">
				<h4 style="color: white; margin-bottom: 15px;">
					<p>3) The patient receives G-CSF for 4 days leading up to his admission for
						his peripheral stem cell harvest. A CD34 count after is 4 μ10-1.
						Outline your approach now.</p>
				</h4>
				<div class="content-row">
					<h4>Your Answer</h4>
					<textarea rows="6" cols="55" placeholder="Answer"></textarea>
				</div>
			</div>
			<div class="question-list hideit" id="model3">
				<div class="content-row">
					<h4>Model Answer</h4>
					<div class="answer-box">
						Sub-optimal CD34 count as <10 μ10-1 indicating chance of obtaining an adequate yield unlikely
						Check – G-CSF compliance, G-CSF dose (10 mcg/kg/day) <br>
						1. Pre-emptive plerixafor therapy240mcg/kg, subcutaneously given and continue with G-CSF <br>
						Plerixafor given that evening and proceed with peripheral stem cell harvest <br>
						Second dose can be given if 6-11 hours pre-apheresis <br>
						Explain potential side-effects of plerixafor – vasovagal reaction, diarrhoea and nausea <br>
						2. Cancel apheresis and arrange a synergistic chemotherapy/ G-CSF collection <br>
						Options include cyclophosphamide (typically 3-4g/m2)/ mesna <br>
						Risk of infection and haemorrhagic cystitis. <br> <br>
						An unlikely scenario if these options fail would be a bone marrow harvest
					</div>
				</div>
			</div>

			<div class="menu_box hideit" id="discussion-box" >
				<h3 class="menu_title shadow alter">Discussion</h3>
				<ul class="ref">
					When assessing patients for a potential autologous stem cell transplant (ASCT) it is important
					to appreciate the risks associated with a poor CD34 positive yield and the actual procedure.
					These should be explained to patients before consent is taken. <br>
					Some important practical points include:
					<ul>
						<li>G-CSF dose – 10mcg/kg/day</li>
						<li>Biosimilar G-CSF preparations should not be used in allogeneic donors</li>
						<li>A peripheral CD34 count of <10 μ10-1 indicates failure</li>
						<li>
							A CD34+ yield of 2 x 106 /kg generally results in rapid
							and sustained haematopoietic recovery although a minimum threshold has not been established
						</li>
					</ul>

					Plerixafor is CXCR4 antagonist that induces rapid mobilisation of CD34+ cells from the bone
					marrow into the peripheral circulation. It can be used pre-emptively or as rescue therapy.
					Due to its high cost (approximately £4000 per dose), pre-emptive use is usually reserved for
					those patients who have failed a previous harvest. Compared to G-CSF alone, plerixafor results
					in a higher optimal CD34+ cell target and fewer apheresis days (DiPersio, Micallef et al. 2009).
					In patients with non-Hodgkin lymphoma (NHL) and multiple myeloma who have failed mobilisation
					with G-CSF alone, one study reported 63% of patients could be rescued and proceed to ASCT
					with good CD34 yield (average 3.1 x 10<sup>6</sup>) (Duarte, Shaw et al. 2011). Thrombocytopenia,
					NHL and previous fludarabine therapy predicted poor responders.
					<br><br>
					Biosimilar G-CSF preparations should not be used in allogeneic donors A peripheral CD34 count
					of <10 μ10-1 indicates failure A CD34+ yield of 2 x 106 /kg generally results in rapid and
					sustained haematopoietic recovery although a minimum threshold has not been established Plerixafor is
					CXCR4 antagonist that induces rapid mobilisation of CD34+ cells from the bone marrow into the
					peripheral circulation. It can be used pre-emptively or as rescue therapy.
					Due to its high cost (approximately £4000 per dose), pre-emptive use is usually reserved
					for those patients who have failed a previous harvest. Compared to G-CSF alone, plerixafor
					results in a higher optimal CD34+ cell target and fewer apheresis days (DiPersio, Micallef et al. 2009).
					In patients with non-Hodgkin lymphoma (NHL) and multiple myeloma who have failed mobilisation with
					G-CSF alone, one study reported 63% of patients could be rescued and proceed to ASCT with good
					CD34 yield (average 3.1 x 10<sup>6</sup>) (Duarte, Shaw et al. 2011). Thrombocytopenia, NHL and previous
					fludarabine therapy predicted poor responders. <br><br>
					Mobilisation with chemotherapy, most commonly cyclophosphamide, has an anti-tumour and works synergistic effect with G-CSF.
					This should be balanced with risks of febrile neutropenia and haemorrhagic cystitis.
				</ul>
			</div>

			<div class="menu_box hideit" id="ref-box" >
				<h3 class="menu_title shadow alter">Reference</h3>
				<ul class="ref">
					Giralt, S., et al. (2014). "Optimizing autologous stem cell mobilization strategies to improve
					patient outcomes: consensus guidelines and recommendations." Biology of Blood and Marrow
					Transplantation 20(3): 295-308 <a target="_blank"
													  href="https://www.ncbi.nlm.nih.gov/pubmed/24141007" style="color: blue">Link</a>

					<br>
					<br>
					Howell, C., et al. (2015). Guideline on the clinical use of apheresis procedures for
					the treatment of patients and collection of cellular therapy products. Transfusion Medicine
					25(2): 57-78 <a target="_blank" href="https://www.ncbi.nlm.nih.gov/pubmed/26013470" style="color: blue">Link</a>
					<br>
					<br>
					DiPersio, J. F., et al. (2009). Phase III prospective randomized double-blind
					placebo-controlled trial of plerixafor plus granulocyte colony-stimulating factor compared
					with placebo plus granulocyte colony-stimulating factor for autologous stem-cell mobilization
					and transplantation for patients with non-Hodgkin's lymphoma. J Clin Oncol 27(28): 4767-4773
					<a target="_blank" href="https://www.ncbi.nlm.nih.gov/pubmed/19720922" style="color: blue">Link</a>
					<br>
					<br>
					Duarte, R., et al. (2011). Plerixafor plus granulocyte CSF can mobilize hematopoietic stem
					cells from multiple myeloma and lymphoma patients failing previous mobilization attempts:
					EU compassionate use data. Bone Marrow Transplantation 46(1): 52-58 <a target="_blank"
																						   href="https://www.ncbi.nlm.nih.gov/pubmed/20305700" style="color: blue">Link</a>
				</ul>
			</div>

			<div class="btns">
				<button class="link-primary" type="button" id="submit" onclick="showans()">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
				<a class="link-primary" href="{{ route('public.samples') }} " style="float: right">Return to sample questions</a>
			</div>
		</div>

		<script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>

		<script>
            function showans() {
                $('#submit').css('display', 'none');

                $('#model1').removeClass('hideit');
                $('#model2').removeClass('hideit');
                $('#model3').removeClass('hideit');
                $('#discussion-box').removeClass('hideit');
                $('#ref-box').removeClass('hideit');
                $('html,body').scrollTop(0);
            }
		</script>
	</div>
@stop