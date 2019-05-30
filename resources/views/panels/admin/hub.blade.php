@extends('layouts.admin')

@section('head')

<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-datepicker.min.js"></script>

@stop

@section('content')

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div> <!-- end .flash-message -->
<div>
	<h2 class="membr_list">Images to add</h2>
</div>

<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>Sno.</th>
		<th>Name</th>
		<th>Fields</th>
	</tr>
	</thead>
		<div>
			@if (count($tablesfigures))
				@foreach ($tablesfigures as $index => $tablesfigure)
					<tr>
						<td> {{ $tablesfigure->figureid }} </td>
						<td>
							{!! Form::open(['url' => url('admin/addfigure')] ) !!}
								Title:<br>
								<input type="hidden" name="figureid" value="{{ $tablesfigure->figureid }}">
								<input type="hidden" name="source" value="discussion">
								<input type="text" name="figuretitle">
								<br>
								Catagory:<br>
								<select name="catagory">
									<option value="transfusion">transfusion</option>
									<option value="haemostasis">haemostasis and thrombosis</option>
									<option value="haemato-oncology">haemato-oncology</option>
									<option value="haemotology">general haemotology</option>
								</select>
								<br>
								Type:<br>
								<select name="type">
									<option value="table">table</option>
									<option value="figure">figure</option>
								</select>
								<br><br>

								<input type="submit" value="Submit">
							{!! Form::close() !!}
						</td>
						<td><img src="https://s3.eu-west-2.amazonaws.com/{{$tablesfigure->bucket_name}}/{{$tablesfigure->figureid}}"></td>
					</tr>
				@endforeach
		</div>
		@endif
</table>

<h2 class="membr_list">Stored Tables/Figures</h2>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>Id</th>
		<th>Name</th>
		<th>Image</th>
	</tr>
	</thead>
	<div>
		@if (count($storedFigures))
			@foreach ($storedFigures as $index => $tablesfigure)
				<tr>
					<td> {{ $tablesfigure->id }} </td>
					<td> {{ $tablesfigure->type }}: {{$tablesfigure->figureid}}  - {{ $tablesfigure->catagory }} </td>
					<td>
						{{ $tablesfigure->title }} <br />
						<img src="https://s3.eu-west-2.amazonaws.com/{{$tablesfigure->bucket_name}}/{{$tablesfigure->figureid}}"></td>
					<td>
						{!! Form::open(['url' => url('admin/resetFigure')] ) !!}
						<input type="hidden" name="figureId" value="{{ $tablesfigure->id }}">
						<input type="submit" value="Reset">
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		@endif
	</div>
</table>
@stop
