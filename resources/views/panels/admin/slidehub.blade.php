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
	</tr>
	</thead>
		<div>
			@if (count($slides))
				@foreach ($slides as $index => $tablesfigure)
					<tr>
						<td> {{ $tablesfigure->name }} in {{ $tablesfigure->bucket_name }} </td>
						<td>
							{!! Form::open(['url' => url('admin/addslide')] ) !!}
								<input type="hidden" name="slideid" value="{{ $tablesfigure->name }}">
								<br>
								Sample type:<br>
								<select name="catagory">
									@if (count($samples))
										@foreach ($samples as $cindex => $sample)
											<option value="{{$sample->id}}">{{$sample->name}}</option>
										@endforeach
									@endif
								</select>
								<br>
								Cases:<br>
								<select name="caseid">
									@if (count($cases))
										@foreach ($cases as $cindex => $case)
											<option value="{{$case->id}}">{{$case->description}}</option>
										@endforeach
									@endif
								</select>
								<br><br>

								<input type="submit" value="Submit">
							{!! Form::close() !!}
						</td>
						{{--<td>--}}
							{{--<img src="https://s3.eu-west-2.amazonaws.com/{{$tablesfigure->bucket_name}}/{{$tablesfigure->plain_name}}_files/1/0_0.jpeg">--}}
						{{--</td>--}}
					</tr>
				@endforeach
		</div>
			@endif
		</div>
</table>

<h2 class="membr_list">Stored Tables/Figures</h2>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>id</th>
		<th>Case type</th>
		<th>Description</th>
		<th>slides</th>
	</tr>
	</thead>
	<div>
		@if (count($cases))
			@foreach ($cases as $index => $case)
				<tr>
					<td> {{ $case->id }} </td>
					<td> {{ $case->catagory }} </td>
					<td> {{ $case->description }} </td>
					<td>
						<?php
							if (isset($case->slides)) {
								foreach ($case->slides as $slide) {
									echo $slide->name . ', ';
								}
							}
						?>
					</td>
					<td>
						{!! Form::open(['url' => url('admin/resetcase')] ) !!}
							<input type="hidden" name="caseId" value="{{ $case->id }}">
							<input type="submit" value="Reset">
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		@endif
	</div>
</table>
@stop
