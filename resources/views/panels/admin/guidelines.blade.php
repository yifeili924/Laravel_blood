@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

{!! Form::open(['url' => route('admin.add-guideline'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
	<div class="form-group">
		<label for="question">Title:</label>
		<textarea class="form-control" name="title"></textarea>
	</div>
	<div class="form-group">
		<label for="question">Summary:</label>
		<textarea class="form-control" name="summary"></textarea>
	</div>
	<div class="form-group">
		<label for="question">References:</label>
		<textarea class="form-control" name="references"></textarea>
	</div>
	<div class="form-group">
		<label for="question">Topics:</label>
		<select name="category">
			<option value="transfusion">transfusion</option>
			<option value="haemostasis">haemostasis and thrombosis</option>
			<option value="haemato-oncology">haemato-oncology</option>
			<option value="haemotology">general haemotology</option>
		</select>
	</div>

	<div class="form-group">
		<label for="question">Draft:</label>
		<input type="checkbox" id="draft" name="draft" checked>
	</div>


	<button name="sub" type="submit" class="btn btn-primary">Submit</button>
{!! Form::close() !!}

	<!-- Nav tabs -->
	<div style="padding: 5px">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item active">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Published</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Drafts</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<div class="rows">
					<table class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sno.</th>
							<th>title</th>
							<th>Action</th>
						</tr>
						</thead>
						@if (isset($results) && count($results))
							<tbody>
							@foreach ($results as $index => $result)
								<tr>
									<td> {{ $index + 1 }} </td>
									<td> <?php echo  base64_decode($result->title);?> </td>
									<td>
										<a class="btn btn-primary btn-sm" href="{{route('admin.edit-guideline', ['id' => $result->id ])}}">Edit</a>
										<a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-guideline', ['id' => $result->id ])}}">Delete</a>
										<a class="btn btn-primary btn-sm" href="{{route('admin.preview-guideline', ['id' => $result->id ])}}">Preview</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						@endif
					</table>
				</div>
			</div>
			<div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">

				<div class="rows">
					<table class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sno.</th>
							<th>title</th>
							<th>Action</th>
						</tr>
						</thead>
						@if (isset($drafts) && count($drafts))
							<tbody>
							@foreach ($drafts as $index => $draft)
								<tr>
									<td> {{ $index + 1 }} </td>
									<td> <?php echo  base64_decode($draft->title);?> </td>
									<td>
										<a class="btn btn-primary btn-sm" href="{{route('admin.edit-guideline', ['id' => $draft->id ])}}">Edit</a>
										<a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-guideline', ['id' => $draft->id ])}}">Delete</a>
										<a class="btn btn-primary btn-sm" href="{{route('admin.preview-guideline', ['id' => $draft->id ])}}">Preview</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						@endif
					</table>
				</div>

			</div>
		</div>
	</div>




@stop