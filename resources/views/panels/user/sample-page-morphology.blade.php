@extends('layouts.sample')
@section('pageTitle', 'Morphology')

@section('content')
@include('partials.status-panel')

<style>
	.hideit { display: none; }
</style>

<div class="container">
	<div class="subtitle">
		<span>Sample Morphology Case</span>
	</div>

	<div class="question fw">
		<p>
			A 53-year-old man presents with a rash. He underwent an allogeneic stem cell transplant
			for AML with complex karyotype two years ago. <br> <br>
			Haemoglobin&nbsp;&nbsp;&nbsp;&nbsp;119 g/l <br>
			Platelets&nbsp;&nbsp;&nbsp;&nbsp;241 x 109/l <br>
			White cell count&nbsp;&nbsp;&nbsp;&nbsp;8.4 x 109/l <br>
		</p>
	</div>

	<div class="row no-padding">
		<div class="question-list">
			<h4 style="color: white; margin-bottom: 15px;"><p>1) Report the blood film</p></h4>
			<div class="content-row">
				<h4>Your Answer</h4>
				<textarea rows="6" cols="55" placeholder="Answer"></textarea>
			</div>
		</div>
		<div class="question-list hideit" id="model1">
			<div class="content-row">
				<h4>Model Answer</h4>
				<div class="answer-box">
					Red cell anisopoikilocytosis <br>
					Numerous target cells <br>
					Spherocytes/ microspherocytes <br>
					Stomatocytes <br>
					Nucleated red cell <br>
					Mild polychromasia <br>
					Features suggest liver disease/ obstructive jaundice <br>
				</div>
			</div>
		</div>

		<div class="question-list">
			<h4 style="color: white; margin-bottom: 15px;"><p>2) What further investigations would you suggest ?</p></h4>
			<div class="content-row">
				<h4>Your Answer</h4>
				<textarea rows="6" cols="55" placeholder="Answer"></textarea>
			</div>
		</div>
		<div class="question-list hideit" id="model2">
			<div class="content-row">
				<h4>Model Answer</h4>
				<div class="answer-box">
					Liver function tests <br>
					Liver screen – hepatitis B/C/E, ferritin, autoantibody screen<br>
					Ultrasound liver including Doppler of portal and hepatic veins <br>
					Liver biopsy <br>
				</div>
			</div>
		</div>

		<div class="question-list">
			<h4 style="color: white; margin-bottom: 15px;"><p>3) What is the differential diagnosis ?</p></h4>
			<div class="content-row">
				<h4>Your Answer</h4>
				<textarea rows="6" cols="55" placeholder="Answer"></textarea>
			</div>
		</div>
		<div class="question-list hideit" id="model3">
			<div class="content-row">
				<h4>Model Answer</h4>
				<div class="answer-box">
					Graft versus host disease of liver <br>
					Obstructive jaundice<br>
					Malignancy of liver/ gall bladder <br>
				</div>
			</div>
		</div>

		<div class="menu_box hideit" id="discussion-box" >
			<h3 class="menu_title shadow alter">Discussion</h3>
			<ul class="ref">
				The main abnormality in the blood film is the large number of target cells.
				The red cells are of normal size and number making iron deficiency, thalassemia trait and
				chronic liver disease secondary to alcohol unlikely. <br><br>
				Target cells result from a relative membrane excess compared to cytoplasm with
				electron microscopy showing these cells are thin and bell shaped resembling a Mexican hat. <br><br>
				They can arise from: <br><br>

				1. A true excess of membrane from high membrane lipid (liver disease, obstructive jaundice, hereditary deficiency of lecithin-cholesterol acyl transferase (LCAT)) <br><br>
				2. Reduced cell volume from low red cell haemoglobin concentration (thalassemia, HbC disease)
				<br>
				<br>
				The hepatic enzyme LCAT has a key role in the pathogenesis of target cells.
				Decreased LCAT activity increases the cholesterol to phospholipid ratio, producing an
				absolute increase in surface area of the red blood cell membrane. Hereditary LCAT deficiency
				also leads to corneal opacities, and kidney disease.
				<br>
				<br>
				The blood film should point towards a diagnosis of cholestatic jaundice and
				in the post allogeneic transplant setting, liver graft vs. host disease (GvHD)
				should be suspected. Other possibilities, as mentioned above, should guide further investigations.
				<br>
				<br>
				The patient was treated with donor lymphocyte infusion for low level disease relapse
				but unfortunately developed skin and liver graft versus host disease (GvHD). At the time
				when this blood film was made, his liver function was markedly abnormal (bilirubin
				531 umol/L, alkaline phosphotase 749 U/l, alanine transaminase 600 U/l, albumin 21 g/l).
				A liver biopsy confirmed liver GvHD. Despite significant immunosuppression he died
				of fulminant liver failure.
			</ul>
		</div>

		<div class="row no-padding img-slider">
			<div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; margin-top: 15px; background: #e7e7e7"></div>
			<div id="openseadragon1" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
		</div>

		<div class="btns">
			<button class="link-primary" type="button" id="submit" onclick="showans()">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
			<a class="link-primary" href="{{ route('public.samples') }} " style="float: right">Return to sample questions</a>
		</div>
	</div>

	<script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
	<script type="text/javascript">
        $('#openseadragon1').prop('hidden', true);
        $('#toolbardiv').prop('hidden', true);
        $('#toolbardiv').prop('hidden', false);
        $('#openseadragon1').prop('hidden', false);
        var viewer = OpenSeadragon({id: 'openseadragon1', prefixUrl: 'https://s3.eu-central-1.amazonaws.com/simplezoom123/kidz_files/',
            tileSources: ['https://s3.eu-west-2.amazonaws.com/bloodacademy/SA48.dzi'],
            toolbar: 'toolbardiv',
            springStiffness:10,
            sequenceMode: true,
            showReferenceStrip:true,
            autoHideControls:false,
            referenceStripScroll:'vertical'});
	</script>

	<script>
        function showans() {
            $('#submit').css('display', 'none');

            $('#model1').removeClass('hideit');
            $('#model2').removeClass('hideit');
            $('#model3').removeClass('hideit');
            $('#discussion-box').removeClass('hideit');
            $('html,body').scrollTop(0);
        }
	</script>
</div>
@stop
