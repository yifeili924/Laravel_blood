  @extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/update-morphology'), 'files' => true, 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Short/ long case:</label>
    <textarea class="form-control" name="short_longcase">{{base64_decode($morphology->short_longcase)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Information:</label>
    <textarea class="form-control" name="information">{{base64_decode($morphology->information)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($morphology->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($morphology->reference)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Type:</label>
    <select name="subject" class="form-control" >
       <option value="short-cases" @if($morphology->type == 'short-cases') selected @endif >Short cases</option>
       <option value="long-cases" @if($morphology->type == 'long-cases') selected @endif >Long cases</option>
       <option value="short-long" @if($morphology->type == 'short-long') selected @endif >Short and long cases</option>
    </select>
  </div>

  <div class="form-group">
    <div class="input_fields_wrap2">
      <button class="add_field_button2" type="button">Add Question & Answers</button>
      <?php
        $qdata = unserialize(base64_decode($morphology->data));
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
  <input type="hidden" name="id"  value="{{$morphology->id}}">
  <div class="form-group">
    <label for="question">Slide:</label>
    <input type="file" name="slide">
  </div>

  <div class="form-group">
    <label for="question">File:</label>
    <input type="text" name="pdf" class="form-control" value="{{$morphology->pdf}}">
  </div>
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$morphology->images}}">
    <?php
      if (!empty($morphology->images)) {
        $images = $morphology->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/morphology') }}/{{$img}}" width="120">
      <?php }
      }
    ?>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
    <input type="hidden" name="simgs" id="finalimages" value="<?php echo $morphology->selimages ?>">
  </div>

  <div class="form-group">
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
      if(!empty($morphology->selimages)) {
        $myname =  $morphology->selimages;
        //echo $myname;
        $imsArray = explode("|", $myname);
        foreach ($imsArray as $imagename) {
          echo "<div id='gall' class='simgz' onclick='sImage(this)''><img width='300' height='200' src=https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "><a href='https://s3.eu-west-2.amazonaws.com/tablesfigures/" . $imagename . "' target='_blank'><div class='desc'>" . $imagename . "</div></a></div>";
        }
      }
    ?>
    <!-- <div class="gallery">
        <a target="_blank" href="img_fjords.jpg">
          <img src="/assets/images/Imagestosend/hyperlink/TransfusionQ3B.jpg" alt="Trolltunga Norway" width="300" height="200">
        </a>
        <div class="desc">Add a description of the image here</div>
      </div>-->
  </div>




  <div class="form-group">
      <input type="hidden" name="sslides" id="finalslides" value="<?php echo $morphology->selslides ?>">
      <button type="button" id="disSlides" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#mySlideModal">
        Add Slides To Question
      </button>
      <span hidden="true" id="deleteslides">
        <a class="btn btn-danger btn-lg">
          <span class="glyphicon glyphicon-trash"></span> Delete
        </a>
      </span>
      <!-- Modal -->
      <div class="modal fade" id="mySlideModal" tabindex="-1" role="dialog" aria-labelledby="mySlideModalLabel">
        <div class="modal-dialog slideModal" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="mySlideModalLabel">Select Slides</h4>
            </div>
            <div class="modal-body">
              <div class="modalslides"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary slidebut" id="slidebut" data-dismiss="modal">Select</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row selectedSlides">
      <?php
        if(isset($morphology->selslides) && $morphology->selslides !=='') {
          $myslides =  $morphology->selslides;
          //echo $myname;
          $imsSlideArray = explode("|", $myslides);
          foreach ($imsSlideArray as $slidename) {
            echo "<div id='slidegall' class='sslidez' onclick='sSlide(this)''>
                        <a href='/admin/slide/getbyname/" . $slidename . "' target='_blank'>
                            <div class='desc'>" . $slidename . "</div>
                        </a>
                  </div>";
          }
        }
      ?>
    </div>






  <button type="submit" class="btn btn-default">Update</button>
{!! Form::close() !!}

@stop
