@extends('layouts.user-page')
@section('pageTitle', 'Morphology Cases')

@section('content')
@include('partials.status-panel')
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

<div class="panel-content">
	<div class="page-title shadow">
		<p>
			<span class="fa fa-navicon" onclick="openNav()"></span>
			Past Interactive case
		</p>
	</div>
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
					<li><span>Haemoglobin: </span><?php echo $icase->haemoglobin;?> x g/l</li>
					<li><span>White cell count: </span><?php echo $icase->whitecell;?> x 10<sup>9</sup>/l</li>
					<li><span>Platelet count: </span><?php echo $icase->platelet;?> x 10<sup>9</sup>/l</li>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 1: KEY MORPHOLOGICAL FEATURES</h3>
				<ul class="ref icase">
					<div class="row" v-for="(slide,i) in slides">
						<div class="col-sm-12">
							<div class="text-center row no-padding" style="margin-bottom: 30px">
								<div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; background: #e7e7e7"></div>
								<div v-bind:id="slide.slidename" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
							</div>
						</div>
						<div class="col-md-6 form-group ui-widget">
							<label for="tags">Your answer(s)</label>
							<table class="table table-striped table-borderless">
								<tr v-for="myitem in feature1" v-if="i == 0">
									<td>@{{ myitem.description }} </td>
								</tr>

								<tr v-for="myitem in feature2" v-if="i == 1">
									<td>@{{ myitem.description }} </td>
								</tr>

								<tr v-for="myitem in feature3" v-if="i == 2">
									<td>@{{ myitem.description }} </td>
								</tr>

								<tr v-for="myitem in feature4" v-if="i == 3">
									<td>@{{ myitem.description }} </td>
								</tr>

								<tr v-for="myitem in feature5" v-if="i == 4">
									<td>@{{ myitem.description }} </td>
								</tr>

								<tr v-for="myitem in feature6" v-if="i == 5">
									<td>@{{ myitem.description }} </td>
								</tr>

								<tr v-for="myitem in feature7" v-if="i == 6">
									<td>@{{ myitem.description }} </td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<div class="feature-chart">
								<div class="menu_box">
									<h3 class="menu_title shadow">Global question Stats (%)</h3>
									<ul class="ref">
										<canvas v-bind:id="'chartfeature' + i" width="600" height="340"></canvas>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 2: SUGGESTIONS FOR FURTHER INVESTIGATIONS</h3>
				<ul class="ref icase">
					<div class="row">
						<div class="col-md-6">
							<label for="tags">Your answer(s)</label>
							<table class="table table-striped table-borderless">
								<tr v-for="myitem in selectedInvestigations">
									<td> @{{ myitem.description }} </td>
								</tr>
							</table>
						</div>

						<div class="col-md-6">
							<div class="feature-chart">
								<div class="menu_box">
									<h3 class="menu_title shadow">Global question Stats (%)</h3>
									<ul class="ref">
										<canvas id="myInvChart" width="600" height="340"></canvas>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 3: DIFFERENTIAL DIAGNOSIS</h3>
				<ul class="ref icase">
					<div class="row">
						<div class="col-md-6">
							<label for="tags">Your answer(s)</label>
							<table class="table table-striped table-borderless">
								<tr v-for="myitem in selectedConcs">
									<td> @{{ myitem.description }} </td>
								</tr>
							</table>
						</div>

						<div class="col-md-6">
							<div class="feature-chart">
								<div class="menu_box">
									<h3 class="menu_title shadow">Global question Stats (%)</h3>
									<ul class="ref">
										<canvas id="myConcChart" width="600" height="340"></canvas>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 4: CASE DESCRIPTION</h3>
				<ul class="ref icase">
					<?php echo $icase->explanation;?>
				</ul>
			</div>

			<div class="row no-padding" style="margin-top: 50px">
				<a class="link-reset" style="margin: 0 20px 20px 0" href="{{ route('subscription.icases') }}">Return</a>
				<a class="link-reset" style="margin: 0 20px 20px 0" href="" onClick="window.print()">Print</a>
				<a class="link-feedback right-floated" data-toggle="modal" data-target="#fbModal">Feedback</a>
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
			slides: JSON.parse('{{$icase->slides}}'.replace(/&quot;/g,'"')),
			features: [],
			inv: [],
			concs: [],
			selectedFeatures: [],
			selectedInvestigations: [],
			selectedConcs: [],
			feature1: [], feature2: [], feature3: [], feature4: [], feature5: [], feature6: [], feature7: [],
			finalFeatureSet: [],
			testFS: [],
			report: []
		},
		methods: {
			initPage: function () {
				this.slides.forEach((x, i) => (
						this.initDragon(x, i)
				));

				axios
					.get('/user/icases/get/useranswers/' + this.icase)
					.then(response => (
							app.selectedInvestigations = response.data.inv,
							app.selectedConcs = response.data.concs,
							app.assignFeatures(response.data.fs)
					));

				axios
					.get('/user/icases/get/report/' + this.icase)
					.then(response => (
							app.report = response.data,
							app.showChart(app.report.conclusions, "myConcChart"),
							app.showChart(app.report.investigations, "myInvChart"),
							app.displayFeatureChart(app.report.featuresets)
					));
			},
			assignFeatures: function (fs) {
				for (let i = 0 ; i < this.slides.length; i++) {
					for (let j = 0; j < fs.length; j++) {
						if (this.slides[i]['id'] === fs[j]["slideId"]) {
							for (let k = 0; k < fs[j]["features"].length; k++) {
								eval('this.feature' + (i+1)).push(fs[j]["features"][k]);
							}
						}
					}
				}
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
			displayFeatureChart: function (featuresets) {
				for(let i = 0; i < this.slides.length; i++) {
					for (let j = 0; j < featuresets.length; j++) {
						if (this.slides[i]['id'] === featuresets[j]["slideId"]) {
							app.showChart(featuresets[j]["features"], "chartfeature" + i);
						}
					}
				}
			},
			showChart: function (data, location) {
				labels = [];
				stats = [];
				data.forEach(datum => {
					labels.push(datum.desc);
					stats.push(datum.perc);
				});

				var ctx = document.getElementById(location).getContext("2d");
				var myChart = new Chart(ctx, {
					type: 'horizontalBar',
					data: {
						labels: labels,
						datasets: [{
							data: stats,
							backgroundColor: 'rgba(43, 83, 129, 0.7)',
							borderColor: 'rgba(43, 83, 129, 0.7)',
							borderWidth: 1
						}]
					},
					options: {
						// responsive: false,
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
								ticks: {
									fontSize: 14
								}
							}]
						}
					}
				});
				$('#stats').show();
				$(".status_section").show();
			}
		},
		mounted() {
			this.initPage()
		}});

</script>
@stop
