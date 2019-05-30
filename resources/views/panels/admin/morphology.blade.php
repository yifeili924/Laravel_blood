@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/add-morphology'), 'files' => true, 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Short/ long case:</label>
    <textarea class="form-control" name="short_longcase"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Information:</label>
    <textarea class="form-control" name="information"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
    <textarea class="form-control" name="discussion"></textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Type:</label>
    <select name="subject" class="form-control" >
       <option value="short-cases">Short cases</option>
       <option value="long-cases">Long cases</option>
       <option value="short-long">Short and long cases</option>
    </select>
  </div>
  <div class="form-group">
    <label for="question">Question 1:</label>
    <textarea class="form-control" name="question[0][0]"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Answer:</label>
    <textarea class="form-control" name="question[0][1]"></textarea>
  </div>
  <div class="form-group">
    <div class="input_fields_wrap2">
      <button class="add_field_button2" type="button">Add Question & Answers</button>
    </div>
  </div>

  <div class="form-group">
    <label for="question">Slide:</label>
    <input type="file" name="slide">
  </div>
    <div class="form-group">
    <label for="question">File Url:</label>
    <input type="text" name="pdf" class="form-control">
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div>

  <div class="form-group">
    <label for="question">Enter slide name :</label>
    <div id="filenamediv">
      <input name="slidename" type="text" id="slidename" class="form-control"/>
      <input type="hidden" name="simgs" id="finalimages" value="">
    </div>
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
    <!-- <div class="gallery">
        <a target="_blank" href="img_fjords.jpg">
          <img src="/assets/images/Imagestosend/hyperlink/TransfusionQ3B.jpg" alt="Trolltunga Norway" width="300" height="200">
        </a>
        <div class="desc">Add a description of the image here</div>
      </div>-->
  </div>


  <div class="form-group">
      <input type="hidden" name="sslides" id="finalslides" value="">
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
    </div>


    <br />
  




  <div class="form-group">
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
        <th>Short/ long case</th>
        <th>Information</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    @if (count($results))
      <tbody>
        @foreach ($results as $index => $result)
            <tr>
              <td> {{ $index + 1 }} </td>
              <td> <?php echo base64_decode($result->short_longcase); ?> </td>
              <td> <?php echo base64_decode($result->information); ?> </td>
              <td> {{ $result->type }} </td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{route('admin.edit-question-morphology', ['id' => $result->id ])}}">Edit</a>
                <a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-question-morphology', ['id' => $result->id ])}}">Delete</a>

                <a class="btn btn-primary btn-sm" href="{{route('admin.preview-question-morphology', ['id' => $result->id ])}}">Preview</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    @endif
  </table>
</div>

@stop
