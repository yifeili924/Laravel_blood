@extends('layouts.main')

@section('head')

@stop

@section('content')
<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/add-mcq-emq'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Awsner:</label>
    <textarea class="form-control" name="question"></textarea>
  </div>   
{!! Form::close() !!}
<hr>


@stop