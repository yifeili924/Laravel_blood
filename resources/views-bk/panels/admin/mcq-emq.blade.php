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
    <label for="email">Answer Type:</label>
    <label class="radio-inline">
        <input type="radio" name="ans_type" value="multiple" class="ans_type" checked>Multiple
    </label>
    <label class="radio-inline">
        <input type="radio" name="ans_type" value="single" class="ans_type">Single
    </label> 
  </div>
  <div class="dy_form multiple_form form-group col-md-8" style="">
    <div class="input_fields_wrap">
      <button class="add_field_button btn">Add More Fields</button>
      <div class="row">
        <div class="col-md-8">
          <input type="text" class="form-control" name="multiple_opts[0]['option']">
        </div>
        <div class="col-md-4">
          <input type="checkbox" name="multiple_opts[0]['answer']">
        </div>
      </div>
    </div>
  <button type="submit" class="btn btn-default">Submit</button>
  </div>   
{!! Form::close() !!}
<hr>

<div class="row">
  <table class="table">
    <thead>
      <tr>
        <th>Sno.</th>
        <th>Question</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    @if (count($results))
      <tbody>
        @foreach ($results as $index => $result)
            <tr>
              <td> {{ $index + 1 }} </td>
              <td> {{ $result->question }} </td>
              <td> {{ $result->type }} </td>
              <td>
                <a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-question-mcq', ['id' => $result->id ])}}">Delete</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    @endif      
  </table>
</div>


@stop