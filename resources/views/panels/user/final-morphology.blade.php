@extends('layouts.user-page')
@section('pageTitle', 'Morphology')

@section('content')
	@include('partials.status-panel')

	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Test Complete
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle"> </div>
			<div class="row no-padding">
				<a class="link-primary" href="{{route('activated.protected')}}">Return to Dashboard</a>
			</div>
		</div>
	</div>
@stop
