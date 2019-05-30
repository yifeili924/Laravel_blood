@extends('layouts.main')

@section('head')

@stop

@section('content')

<h2>Add Member</h2>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{!! Form::open(['url' => url('admin/add-member'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="email">Name:</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="email">Current hospital:</label>
    <input type="text" class="form-control" id="current_hospital" name="current_hospital">
  </div>
  <div class="form-group">
    <label for="email">Country Residence:</label>
    <input type="text" class="form-control" id="country_residence" name="country_residence">
  </div>
  <div class="form-group">
    <label for="email">Haematology trainee/ scientist:</label>
    <input type="text" class="form-control" id="haematology" name="haematology">
    <input type="hidden" name="user_id">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}



@stop