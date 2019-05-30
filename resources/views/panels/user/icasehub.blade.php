@extends('layouts.user-page')
@section('pageTitle', 'Interactive Case Reports')

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
			Interactive case
		</p>
	</div>
	<div class="page-content">
		<div id="app">
			<div class="clearfix" style="margin-bottom: 20px">
				<a class="link-reset right-floated" data-toggle="modal" data-target="#caseModal">Instructions</a>
			</div>

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
					<li><span>Haemoglobin: </span><?php echo $icase->haemoglobin;?> g\l</li>
					<li><span>White cell count: </span><?php echo $icase->whitecell;?> x 10<sup>9</sup>/l</li>
					<li><span>Platelet count: </span><?php echo $icase->platelet;?> x 10<sup>9</sup>/l</li>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 1: KEY MORPHOLOGICAL FEATURES</h3>
				<ul class="ref icase">
					<div class="row" v-for="(slide,i) in slides">
						<div class="col-md-7 col-sm-12">
							<div class="text-center row no-padding" style="margin-bottom: 30px">
								<div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; background: #e7e7e7"></div>
								<div v-bind:id="slide.slidename" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
							</div>
						</div>
						<div class="col-md-5 col-sm-12 form-group ui-widget">
							<label for="tags">Select features (maximum of 5)</label>
							<input v-bind:id="'tags'+ i" type="text" class="form-control">

							<table class="table table-striped table-borderless">
								<tr v-for="myitem in feature1" v-if="i == 0">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature1)">delete</button></td>
								</tr>

								<tr v-for="myitem in feature2" v-if="i == 1">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature2)">delete</button></td>
								</tr>

								<tr v-for="myitem in feature3" v-if="i == 2">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature3)">delete</button></td>
								</tr>

								<tr v-for="myitem in feature4" v-if="i == 3">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature4)">delete</button></td>
								</tr>

								<tr v-for="myitem in feature5" v-if="i == 4">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature5)">delete</button></td>
								</tr>

								<tr v-for="myitem in feature6" v-if="i == 5">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature6)">delete</button></td>
								</tr>

								<tr v-for="myitem in feature7" v-if="i == 6">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, feature7)">delete</button></td>
								</tr>
							</table>

						</div>
					</div>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 2: SUGGESTIONS FOR FURTHER INVESTIGATIONS</h3>
				<ul class="ref icase">
					<div class="row">
						<div class="col-lg-6">
							<label for="tags">Select investigation (maximum of 5)</label>
							<input id="tagsinvestigation" type="text" class="form-control">
						</div>

						<div class="col-lg-6">
							<table class="table table-striped table-borderless">
								<tr v-for="myitem in selectedInvestigations">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, selectedInvestigations)">delete</button></td>
								</tr>
							</table>
						</div>
					</div>
				</ul>
			</div>

			<div class="menu_box">
				<h3 class="menu_title shadow icase">SECTION 3: DIFFERENTIAL DIAGNOSIS</h3>
				<ul class="ref icase">
					<div class="row">
						<div class="col-lg-6">
							<label for="tags">Select diagnosis (maximum of 5)</label>
							<input id="tagsdiagnosis" type="text" class="form-control">
						</div>

						<div class="col-lg-6">
							<table class="table table-striped table-borderless">
								<tr v-for="myitem in selectedConcs">
									<td style="vertical-align: middle">@{{ myitem.description }} </td>
									<td style="width: 100px"><button class="btn_feature_delete" v-on:click="deleteFeature(myitem, selectedConcs)">delete</button></td>
								</tr>
							</table>
						</div>
					</div>
				</ul>
			</div>

			<div class="row no-padding" style="margin-top: 50px">
				<button class="link-reset" v-on:click="submitAnswer(false)" style="margin: 0 20px 20px 0">Save and Return</button>
				<a class="link-reset" style="margin: 0 20px 20px 0" href="{{ route('subscription.icases') }}">Return</a>
				<button class="link-primary right-floated" data-toggle="modal" data-target="#submitModal" style="margin: 0 0 20px">Submit</button>
			</div>

			<div id="submitModal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="top">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="content">
						<p>Your submission can be modified until the closing date of the case</p>
						<button class="link-primary" v-on:click="submitAnswer(true)" style="margin: 0 0 20px">Submit</button>
					</div>
				</div>
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
			features: [],
			inv: [],
			concs: [],
			selectedFeatures: [],
			selectedInvestigations: [],
			selectedConcs: [],
			feature1: [], feature2: [], feature3: [], feature4: [], feature5: [], feature6: [], feature7: [],
			finalFeatureSet: [],
			testFS: [],
			maxEntries: 5
		},
		methods: {
			assignFinalFeatureSet: function (slideId, index) {
				var feature = eval("this.feature" + index);
				var tempObj = {};
				tempObj.slideId = slideId;
				var tempArray = [];
				feature.forEach(f => (
						tempArray.push(f.id)
				));
				tempObj.features = tempArray;
				this.finalFeatureSet.push(tempObj);
			},
			submitAnswer: function (finalised) {
				this.finalFeatureSet = [];
				this.slides.forEach((slide, index) => (
						this.assignFinalFeatureSet(slide.id, index+1)
				));
				axios
					.post('/user/icase/answer/submit', {
						investigations: this.selectedInvestigations,
						concs: this.selectedConcs,
						featureset: this.finalFeatureSet,
						caseId: this.icase,
						finalised: finalised
					})
					.then(function (response) {
						console.log("OK");
						window.location.href = '/user/icases';
					});
			},
			deleteFeature: function (myitem, featureList) {
				for( var i = 0; i <= featureList.length -1; i++){
					if ( featureList[i].id === myitem.id) {
						featureList.splice(i, 1);
						break;
					}
				}
			},
			setupAuto: function (features, slidename) {
				var selector = $("#tags" + slidename);
				if (slidename < 10) {
					this.testFS.push({"features": []});
				}
				var options = {
					data: features,
					getValue: "description",

					list: {
						onChooseEvent: function() {
							var selectedItemValue = selector.getSelectedItemData();
							selector.val("");

							if (!isNaN(slidename)) {
								var newIndex= slidename + 1;
								for (i = 0; i < eval('app.feature'+newIndex).length ; i++) {
									if (eval('app.feature'+newIndex)[i].id === selectedItemValue.id || eval('app.feature'+newIndex).length === app.maxEntries) {
										return;
									}
								}
								eval('app.feature'+newIndex).push(selectedItemValue);
							}

							if (slidename === "investigation") {
								for (i = 0; i < app.selectedInvestigations.length ; i++) {
									if (app.selectedInvestigations[i].id === selectedItemValue.id || app.selectedInvestigations.length === app.maxEntries) {
										return;
									}
								}
								app.selectedInvestigations.push(selectedItemValue);
							}
							if (slidename === "diagnosis") {
								for (i = 0; i < app.selectedConcs.length ; i++) {
									if (app.selectedConcs[i].id === selectedItemValue.id || app.selectedConcs.length === app.maxEntries) {
										return;
									}
								}
								app.selectedConcs.push(selectedItemValue);
							}
						},
						maxNumberOfElements: 10,
						match: {
							enabled: true
						},
					},
					theme: "plate-dark",
					minCharNumber: 3
				};

				selector.easyAutocomplete(options);
			},
			initPage: function () {
				axios
					.get('/user/icases/get/features')
					.then(response => (
						app.features = response.data.feature,
						app.investigations = response.data.inv,
						app.concs = response.data.conc,
						this.slides.forEach((x, i) => (
								this.initDragon(x, i)
						)),
						this.setupAuto(this.investigations, "investigation"),
						this.setupAuto(this.concs, "diagnosis")
					));

				axios
						.get('/user/icases/get/useranswers/' + this.icase)
						.then(response => (
								app.selectedInvestigations = response.data.inv,
								app.selectedConcs = response.data.concs,
								app.assignFeatures(response.data.fs)
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

				this.setupAuto(this.features, index)
			},
		},
		mounted() {
			this.initPage()
		}});

</script>
@stop
