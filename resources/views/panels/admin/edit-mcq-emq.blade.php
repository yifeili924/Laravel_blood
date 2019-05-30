@extends('layouts.admin')

@section('head')

@stop

@section('content')
@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif
<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/update-mcq-emq'), 'files'=>true,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question">{{base64_decode($mcq->question)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($mcq->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($mcq->reference)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >
       <option @if($mcq->subject == 'general-haematology') selected @endif value="general-haematology">General haematology</option>
       <option @if($mcq->subject == 'transfusion') selected @endif value="transfusion">Transfusion</option>
       <option @if($mcq->subject == 'haemato-oncology') selected @endif value="haemato-oncology">Haemato-oncology</option>
       <option @if($mcq->subject == 'haemastasis-thrombosis') selected @endif value="haemastasis-thrombosis">Haemastasis and thrombosis</option>
    </select>
  </div>

  <div class="form-group">
    <label for="email">Answer Type:</label>
    <label class="radio-inline">
        {{$mcq->type}}
    </label>
    <input type="hidden" name="id" value="{{$mcq->id}}">
  </div>
  <?php
    $questions = unserialize(base64_decode($mcq->data));
    // echo "<pre>";
    // print_r($questions);
    // echo "</pre>";
  ?>
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$mcq->images}}">
    <?php
      if (!empty($mcq->images)) {
        $images = $mcq->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/mcq') }}/{{$img}}" width="120">
      <?php }
      }
    ?>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div>


  <div class="form-group">
      <input type="hidden" name="simgs" id="finalimages" value="<?php echo $mcq->selimages ?>">
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
        if(!empty($mcq->selimages)) {
          $myname =  $mcq->selimages;
          //echo $myname;
          $imsArray = explode("|", $myname);
          foreach ($imsArray as $imagename) {
            echo "<div id='gall' class='simgz' onclick='sImage(this)''><img width='300' height='200' src=https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "><a href='/assets/images/Imagestosend/discussion/" . $imagename . "' target='_blank'><div class='desc'>" . $imagename . "</div></a></div>";
          }
        }
      ?>
    </div>



  <div class="dy_form multiple_form form-group col-md-8" style="">
    @if($mcq->type == 'single')
      <div class="input_fields_wrap_emq emq-form">
        <button class="add_field_button_emq" type="button">Add Answer</button>
          <?php $x = 0;
          $questions = unserialize(base64_decode($mcq->data));
          ?>

          @foreach($questions as $key=>$question)
            <div class="row">
              <textarea name="multiple_opts2[{{$key}}][0]">{{$questions[$key][0]}}</textarea>
              <div class="input_fields_wrap_emq_inr" data-id='0'>
                  <button class="add_field_button_emq_inr" type="button">Add Answer Options</button>
                  <?php $v = 0; ?>
                  @foreach($question as $key2=>$opt)
                    @if(gettype($opt) == 'array')
                      <div class="row2" id="existingChoices{{$key}}">
                        <input type="text" name="multiple_opts2[{{$key}}][{{$v}}][1]" value="{{$opt[1]}}">
                            <input type="radio" onchange="deselectOthers({{$key}}, {{$v}});" id="stemChoice{{$key}}{{$v}}" name="multiple_opts2[{{$key}}][{{$v}}][2]" @if(isset($opt[2]) && $opt[2] == 'on') checked @endif>
                      </div>
                    @endif
                    <?php $v++; ?>
                   @endforeach
              </div>
              <?php $x++; ?>
            </div>
          @endforeach
      </div>
    @else
      <div class="input_fields_wrap">
        <div class="form-group row">
          <div class="col-md-7">
            <button class="add_field_button btn" type="button">Add Answer options</button>
          </div>
          <div class="col-md-2">
            <label style="float: right;">Right Answer</label>
          </div>
        </div>
        @foreach($questions as $question)
          <div class="row">
            <div class="col-md-8">
              <input type="text" class="form-control inpt" value="{{$question[0]}}" name="multiple_opts[{{$loop->index}}][0]">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="multiple_opts[{{$loop->index}}][1]" @if(isset($question[1]) && $question[1] == 'on') checked @endif>
            </div>
          </div>
        @endforeach
      </div>
    @endif
    <input type="hidden" name="ans_type" value="{{$mcq->type}}">
  <button type="submit" class="btn btn-default">Submit</button>
  </div>
{!! Form::close() !!}

@stop
