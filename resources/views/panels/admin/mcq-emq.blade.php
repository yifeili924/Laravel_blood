@extends('layouts.admin')

@section('head')

@stop

@section('content')
@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif
<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/add-mcq-emq'),'files' => true ,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion:</label>
    <textarea class="form-control" name="discussion"></textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >
       <option value="general-haematology">General haematology</option>
       <option value="transfusion">Transfusion</option>
       <option value="haemato-oncology">Haemato-oncology</option>
       <option value="haemastasis-thrombosis">Haemastasis and thrombosis</option>
    </select>
  </div>
  <div class="form-group">
    <label for="email">Answer Type:</label>
    <label class="radio-inline">
        <input type="radio" name="ans_type" value="multiple" class="ans_type" checked>MCQs
    </label>
    <label class="radio-inline">
        <input type="radio" name="ans_type" value="single" class="ans_type">EMQs
    </label>
  </div>
  <div class="dy_form multiple_form form-group">
    <div class="input_fields_wrap mcq-form">
      <button class="add_field_button btn " type="button">Add Answer</button>

      <div class="row">
        <div class="col-md-8">
          <textarea class="form-control inpt" name="multiple_opts[0][0]"></textarea>
        </div>
        <div class="col-md-4">
          <input type="checkbox" name="multiple_opts[0][1]">
        </div>
      </div>
    </div>
    <div class="input_fields_wrap_emq emq-form" style="display: none;">
      <div class="row">
        <button type="button" id="addChoice" class="btn btn-primary">Add Choice</button>
      </div>
      <br />
      <div id="choices">
        <div class="col-lg-12" style="margin-bottom: 5px">
          <div class="form-group">
            <label for="name" class="col-lg-1">Choice 0:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="choice[0]" id="choiceId[0]" value="0">
            </div>
            <div class="col-lg-1">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <button type="button" id="addStem" class="btn btn-primary">Add Stems</button>
      </div>
      <div id="stems">
        <div class="col-lg-12"  id = "stemrow0" style="margin-bottom: 10px">
          <div class="col-lg-12" style="margin-bottom: 10px">
            <div class="form-group">
              <label for="name" class="col-lg-1">Stem 0:</label>
              <div class="col-lg-7">
                <textarea type="text" class="form-control" name="stem[0]" id="stemId[0]"></textarea>
              </div>
              <div class="col-lg-1">
                <select id="currentChoices0" onchange="displaySelected(0, this);">
                  <option value="select">select</option>
                </select>
              </div>
              <div class="col-lg-2" id="labelSpaceStem[0]">
                <input type="hidden"  class="form-control" name="selectedchoice2[0]" id="selectedchoice0" value="">
              </div>
              <div class="col-lg-1">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <input type="hidden" name="simgs" id="finalimages" value="">
      <button type="button" id="disImages" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Add Images To Discussion
      </button>
      <span hidden="true" id="deleteimages">
        <a class="btn btn-danger btn-lg">
          <span class="glyphicon glyphicon-trash"></span> Delete
        </a>
      </span>
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog imgModal" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Select Images</h4>
            </div>
            <div class="modal-body">
              <div class="modalimages"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary imgbut" id="imgbut" data-dismiss="modal">Select</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row selectedImages">
    </div>
    <br />
    <button type="submit" class="btn btn-default">Submit</button>
  </div>
{!! Form::close() !!}
<hr>
<h3>Listing</h3>
<div class="rows">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Sno.</th>
          <th>app id</th>
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
                <td>{{$result->id}}</td>
              <td> <?php echo base64_decode($result->question); ?></td>
              <td> {{ $result->type }} </td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{route('admin.edit-question-mcq', ['id' => $result->id ])}}">Edit</a>
                <a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-question-mcq', ['id' => $result->id ])}}">Delete</a>
                <a class="btn btn-primary btn-sm" href="{{route('admin.preview-question-mcq', ['id' => $result->id ])}}">Preview</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    @endif
  </table>
</div>

@stop
