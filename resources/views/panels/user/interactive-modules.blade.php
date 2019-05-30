@extends('layouts.user-page')
@section('pageTitle', 'Guideline Summaries')

@section('content')
	@include('partials.status-panel')
	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Interactive modules
			</p>
		</div>
		<div class="page-content">
			<p class="subtitle"></p>
			<div>
				<div class="tab shadow">
					<button class="tablinks active fullwidth">Modules (Requires flash)</button>
					{{--<button class="tablinks secondTab">Haemostasis and Thrombosis</button>--}}
					{{--<button class="tablinks thirdTab">Transfusion</button>--}}
					{{--<button class="tablinks fourthTab">General Haematology</button>--}}
				</div>
				<div class="tablist">
					<div id="mailgnant" class="tabcontent tabshow">
						<div class="content-row flexDiv icase">
							<div class="desc-image">
								<a href="{{route('subscription.gim', ["title"=> "Clinical flow cytometry: principle","modFolder" => "ImmunophenotypigPRINCIPLESmodule", "moduleName" => "Part1Immunophenotyping.htm"])}}"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>
							</div>
							<div class="col-separator hublist"></div>
							<div class="sample-desc">
								<a href="{{route('subscription.gim', ["title"=> "Clinical flow cytometry: principle","modFolder" => "ImmunophenotypigPRINCIPLESmodule", "moduleName" => "Part1Immunophenotyping.htm"])}}">
									Clinical flow cytometry: principle
								</a>
							</div>
						</div>
						<div class="content-row flexDiv icase">
							<div class="desc-image">
								<a href="{{route('subscription.gim', ["title"=> "An Introduction to Laboratory Quality Assurance", "modFolder" => "Lab_quality_assurance_module_V2", "moduleName" => "IntroductiontolaboratoryqualityassurancemoduleV2.htm"])}}"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>
							</div>
							<div class="col-separator hublist"></div>
							<div class="sample-desc">
								<a href="{{route('subscription.gim', ["title"=> "An Introduction to Laboratory Quality Assurance", "modFolder" => "Lab_quality_assurance_module_V2", "moduleName" => "IntroductiontolaboratoryqualityassurancemoduleV2.htm"])}}">
									An Introduction to Laboratory Quality Assurance
								</a>
							</div>
						</div>
						<div class="content-row flexDiv icase">
							<div class="desc-image">
								<a href="{{route('subscription.gim', ["title"=> "Cases in Clinical Immunophenotyping","modFolder" => "CASESinImmunophenotyping_module", "moduleName" => "Casesinimmunopenotyping.htm"])}}"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>
							</div>
							<div class="col-separator hublist"></div>
							<div class="sample-desc">
								<a href="{{route('subscription.gim', ["title"=> "Cases in Clinical Immunophenotyping","modFolder" => "CASESinImmunophenotyping_module", "moduleName" => "Casesinimmunopenotyping.htm"])}}">
									Cases in Clinical Immunophenotyping
								</a>
							</div>
						</div>
					</div>

					{{--<div id="haemostasis" class="tabcontent">--}}
						{{--<div class="content-row flexDiv">--}}
							{{--<div class="desc-image">--}}
								{{--<a href="/user/guidelinesummaries/"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>--}}
							{{--</div>--}}
							{{--<div class="col-separator" style="left: 110px"></div>--}}
							{{--<div class="sample-desc">--}}
								{{--Hello World 2--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}

					{{--<div id="transfusion" class="tabcontent">--}}
						{{--<div class="content-row flexDiv">--}}
							{{--<div class="desc-image">--}}
								{{--<a href="/user/guidelinesummaries/"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>--}}
							{{--</div>--}}
							{{--<div class="col-separator" style="left: 110px"></div>--}}
							{{--<div class="sample-desc">--}}
								{{--Hello World 3--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}

					{{--<div id="general-haematology" class="tabcontent">--}}
						{{--<div class="content-row flexDiv">--}}
							{{--<div class="desc-image">--}}
								{{--<a href="/user/guidelinesummaries/"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>--}}
							{{--</div>--}}
							{{--<div class="col-separator" style="left: 110px"></div>--}}
							{{--<div class="sample-desc">--}}
								{{--Hello world 4--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}

				</div>
			</div>

			<div class="clearfix"></div>
		</div>
	</div>
@stop
