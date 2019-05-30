@extends('layouts.admin')

@section('head')

@stop

@section('content')

<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/update-essay-ques'), 'files'=>true ,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question">{{base64_decode($essay->question)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Answer:</label>
    <textarea class="form-control" name="answer">{{base64_decode($essay->answer)}}</textarea>
    <input type="hidden" name="id" value="{{$essay->id}}">
  </div>
    <div class="form-group">
    <label for="question">Discussion:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($essay->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Topic:</label>
    <textarea class="form-control" name="topic">{{base64_decode($essay->topic)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($essay->reference)}}</textarea>
  </div>
   <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >

       <option @if($essay->subject == 'general-haematology') selected @endif value="general-haematology">General haematology</option>
       <option @if($essay->subject == 'transfusion') selected @endif value="transfusion">Transfusion</option>
       <option @if($essay->subject == 'haemato-oncology') selected @endif value="haemato-oncology">Haemato-oncology</option>
       <option @if($essay->subject == 'haemastasis-thrombosis') selected @endif value="haemastasis-thrombosis">Haemastasis and thrombosis</option>

    </select>
  </div>
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$essay->images}}">
    <?php
      if (!empty($essay->images)) {
        $images = $essay->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/essay') }}/{{$img}}" width="120">
      <?php }
      }
    ?>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div>

  <div class="form-group">
    <input type="hidden" name="simgs" id="finalimages" value="<?php echo $essay->selimages ?>">
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
      if(!empty($essay->selimages)) {
        $myname =  $essay->selimages;
        //echo $myname;
        $imsArray = explode("|", $myname);
        foreach ($imsArray as $imagename) {
          echo "<div id='gall' class='simgz' onclick='sImage(this)''><img width='300' height='200' src=https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "><a href='https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "' target='_blank'><div class='desc'>" . $imagename . "</div></a></div>";
        }
      }
    ?>
  </div>

  <button type="submit" class="btn btn-default">Update</button>
{!! Form::close() !!}


@stop
