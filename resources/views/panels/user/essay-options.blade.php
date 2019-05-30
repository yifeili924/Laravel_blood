@extends('layouts.user-page')
@section('pageTitle', 'Essay Options')

@section('content')
@include('partials.status-panel')
	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Essays
			</p>
		</div>
		<div class="page-content">
			<p class="subtitle">Use the information tab to get quick tips</p>
			<div>
				<div class="tab shadow">
					<button class="tablinks firstTab active">Questions</button>
					<button class="tablinks secondTab">Information</button>
				</div>
				<div class="tablist">
					<div id="questions" class="tabcontent tabshow">
						{!! Form::open(['url' => route('user.get-essay-ques'), 'data-parsley-validate' ] ) !!}
						<div class="content-row">
							<span class="row-label">General haematology</span>
							<div class="row-data">
								@if (count($general))
									@foreach($general as $gen)
										<label class="checkcontainer"><?php echo base64_decode($gen->topic); ?>
											<input type="radio" name="general-haematology" value="{{$gen->id}}" checked>
											<span class="radiomark"></span>
										</label>
									@endforeach
								@endif
							</div>
						</div>
						<div class="content-row">
							<span class="row-label">Transfusion</span>
							<div class="row-data">
								@if (count($transfusion))
									@foreach($transfusion as $ten)
										<label class="checkcontainer"><?php echo base64_decode($ten->topic); ?>
											<input type="radio" name="general-haematology" value="{{$ten->id}}" checked>
											<span class="radiomark"></span>
										</label>
									@endforeach
								@endif
							</div>
						</div>
						<div class="content-row">
							<span class="row-label">Haemato-oncology</span>
							<div class="row-data">
								@if (count($haemato))
									@foreach($haemato as $hae)
										<label class="checkcontainer"><?php echo base64_decode($hae->topic); ?>
											<input type="radio" name="general-haematology" value="{{$hae->id}}" checked>
											<span class="radiomark"></span>
										</label>
									@endforeach
								@endif
							</div>
						</div>
						<div class="content-row">
							<span class="row-label">Haemastasis and thrombosis</span>
							<div class="row-data">
								@if (count($haemastasis))
									@foreach($haemastasis as $haem)
										<label class="checkcontainer"><?php echo base64_decode($haem->topic); ?>
											<input type="radio" name="general-haematology" value="{{$haem->id}}" checked>
											<span class="radiomark"></span>
										</label>
									@endforeach
								@endif
							</div>
						</div>
						<div class="content-row">
							<button class="link-primary">Start &nbsp;<i class="fa fa-angle-double-right"></i></button>
						</div>
						{!! Form::close() !!}
					</div>

					<div id="information" class="tabcontent info-tab boxize">
						<div class="content-row">
							<p><?php echo base64_decode($essay); ?></p>
						</div>
					</div>
				</div>

				<div class="flash-message">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
						@if(Session::has('alert-' . $msg))
							<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
						@endif
					@endforeach
				</div> <!-- end .flash-message -->
			</div>

			<div class="clearfix"></div>
		</div>
	</div>
@stop
