@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/add-guideline'), 'files'=>true,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Case :</label>
    <textarea class="form-control" name="title">{{base64_decode($transfusion->title)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Information:</label>
    <textarea class="form-control" name="summary">{{base64_decode($transfusion->summary)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
    <textarea class="form-control" name="references">{{base64_decode($transfusion->reference)}}</textarea>
  </div>
  <input type="hidden" name="id" value="{{$transfusion->id}}">
  <div class="form-group">
    <label for="question">Topics:</label>
    <select name="category">
      <option value="transfusion" {{$transfusion->category === "transfusion" ? "selected" : ""}}>transfusion</option>
      <option value="haemostasis" {{$transfusion->category === "haemostasis" ? "selected" : ""}}>haemostasis and thrombosis</option>
      <option value="haemato-oncology" {{$transfusion->category === "haemato-oncology" ? "selected" : ""}}>haemato-oncology</option>
      <option value="haemotology" {{$transfusion->category === "haemotology" ? "selected" : ""}}>general haemotology</option>
    </select>
  </div>

    <div class="form-group">
        <label for="question">Draft:</label>
        <input type="checkbox" id="draft" name="draft" {{$transfusion->draft === 1 ? "checked" : ""}}>
    </div>

  <button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
