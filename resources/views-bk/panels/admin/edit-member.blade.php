@extends('layouts.main')

@section('head')

@stop

@section('content')

<h2>Member</h2>



{!! Form::open(['url' => url('admin/update-member'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="email">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="{{$user['first_name']}}">
  </div>
  <div class="form-group">
    <label for="email">Current hospital:</label>
    <input type="text" class="form-control" id="current_hospital" name="current_hospital" value="{{$user['current_hospital']}}">
  </div>
  <div class="form-group">
    <label for="email">Country Residence:</label>
    <input type="text" class="form-control" id="country_residence" name="country_residence" value="{{$user['country_residence']}}">
  </div>
  <div class="form-group">
    <label for="email">Haematology trainee/ scientist:</label>
    <input type="text" class="form-control" id="haematology" name="haematology" value="{{$user['haematology']}}">
    <input type="hidden" name="user_id" value="{{$user['id']}}">
  </div>
   <?php 
    $todayDate = date('U');
    $expireDate = date('U', strtotime($user['expire_at']));
    if($user['subscription'] == 1 && !empty($user['expire_at']) && $todayDate < $expireDate) { ?>
      <a onclick="return confirm('Are you sure?')" href="{{route('admin.end-subs', ['id' => $user['id'] ])}}"  class="btn btn-danger">Cancel membership</a>
    <?php } ?>
  <button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}



@stop