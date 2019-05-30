@extends('layouts.sample')
@section('pageTitle', 'Interactive case')

@section('content')

<link rel="stylesheet" href="{{asset('assets/css/easy-autocomplete.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/easy-autocomplete.themes.min.css')}}">
<style>
	.easy-autocomplete.eac-plate-dark ul li {
		font-family: Verdana,Arial,sans-serif;
		font-size: 18px;
	}

</style>
<script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
<script src="{{ asset('assets/js/openseadragon-annotations.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('assets/js/jquery.easy-autocomplete.min.js')}}"></script>

@if (session('message'))
	<script type="text/javascript">
		$(document).ready(function () {
			$('#logModal').modal('show');
		});
	</script>
@endif

@if (session()->has('errors'))
	<script type="text/javascript">
		$(document).ready(function () {
			$('#signModal').modal('show');
		});
	</script>
@endif

<div class="panel-content">
	<div class="page-content">
		<div id="app">
			<div class="case-summary clearfix">
				<div style="display: inline-block">
					<p>Case Submitted by: BloodAcademy</p>
					{{--<p>Number of participants: {{count($icase->submissions)}}</p>--}}
				</div>
				<p class="right-floated">Published: {{date('d-m-Y', strtotime($icase->publish_date))}}</p>
				<p class="right-floated">Closing date for submission: {{date('d-m-Y', strtotime($icase->closing_date))}}</p>
			</div>

			<div class="case-description">
				<?php echo $icase->description;?>
				<ul>
					<li><span>Haemoglobin: </span><?php echo $icase->haemoglobin;?> g/l</li>
					<li><span>White cell count: </span><?php echo $icase->whitecell;?> x 10<sup>9</sup>/l</li>
					<li><span>Platelet count: </span><?php echo $icase->platelet;?> x 10<sup>9</sup>/l</li>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">MORPHOLOGICAL FEATURES</h3>
				<ul class="ref icase">
					<div class="row" v-for="(slide,i) in slides">
						<div class="col-sm-12">
							<div class="text-center row no-padding" style="margin-bottom: 30px">
								<div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; background: #e7e7e7"></div>
								<div v-bind:id="slide.slidename" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
							</div>
						</div>
					</div>
				</ul>
			</div>

			<div class="row no-padding" style="margin-top: 50px">
				<button class="link-reset" data-toggle="modal" data-target="#signModal" style="margin: 0 20px 20px 0">Register</button>
				<button class="link-reset" data-toggle="modal" data-target="#logModal" style="margin: 0 20px 20px 0">Login</button>
			</div>
		</div>
	</div>
</div>


<script>
	var app = new Vue({
		el: '#app',
		data: {
			bucketpre: "https://s3.eu-west-2.amazonaws.com/",
			icase: '{{$icase->id}}',
			caseDescription: '',
			slides: JSON.parse('{{$icase->slides}}'.replace(/&quot;/g,'"')),
		},
		methods: {
			initPage: function () {
				this.slides.forEach((x, i) => (
						this.initDragon(x, i)
				));
			},
			initDragon: function (slide, index) {
				var slideName = this.bucketpre + slide.bucket_name + "/" + slide.slidename;
				viewer = OpenSeadragon({
					id: slide.slidename,
					showNavigator:  true,
					constrainDuringPan: true,
					prefixUrl: "https://s3.eu-central-1.amazonaws.com/simplezoom123/kidz_files/",
					tileSources: [slideName] ,

				});
				viewer.initializeAnnotations();
				this.viewer = viewer;
			},
		},
		mounted() {
			this.initPage()
		}});

</script>
@stop
