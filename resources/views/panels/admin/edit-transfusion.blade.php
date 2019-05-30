@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/update-transfusion'), 'files'=>true,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Case :</label>
    <textarea class="form-control" name="qcase">{{base64_decode($transfusion->qcase)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Information:</label>
    <textarea class="form-control" name="information">{{base64_decode($transfusion->information)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($transfusion->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($transfusion->reference)}}</textarea>
  </div>
  <div class="form-group">
    <div class="input_fields_wrap2">
      <button class="add_field_button2" type="button">Add Question & Answers</button>
      <?php
        $qdata = unserialize(base64_decode($transfusion->data));
        $i = 1;
        foreach ($qdata as $key => $value) {
          ?>
          <div class="row2">
            <div class="form-group">
              <label for="question">Question {{$i}}:</label>
              <textarea class="form-control" name="question[{{$i}}][0]">{{$value[0]}}</textarea>
            </div>
            <div class="form-group">
              <label for="question">Answer:</label>
              <textarea class="form-control" name="question[{{$i}}][1]">{{$value[1]}}</textarea>
            </div>
          </div>
        <?php $i++; }
      ?>
    </div>
  </div>
    <input type="hidden" name="id" value="{{$transfusion->id}}">
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$transfusion->images}}">
    <?php
      if (!empty($transfusion->images)) {
        $images = $transfusion->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/transfusion') }}/{{$img}}" width="120">
      <?php }
      }
    ?>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div>

  <div class="form-group">
    <input type="hidden" name="simgs" id="finalimages" value="<?php echo $transfusion->selimages ?>">
    <button type="button" id="disImages" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
      Add Images To Discussion Ali!
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
            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
          </div>
          <div class="modal-body">
            <div class="modalimages"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary imgbut" id="imgbut" data-dismiss="modal">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row selectedImages">
    <?php
      if(!empty($transfusion->selimages)) {
        $myname =  $transfusion->selimages;
        //echo $myname;
        $imsArray = explode("|", $myname);
        foreach ($imsArray as $imagename) {
          echo "<div id='gall' class='simgz' onclick='sImage(this)''><img width='300' height='200' src=https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "><a href='https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "' target='_blank'><div class='desc'>" . $imagename . "</div></a></div>";
        }
      }
    ?>
  </div>

  <button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
