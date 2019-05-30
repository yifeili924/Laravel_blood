@extends('layouts.admin')

@section('head')

@stop

@section('content')

<div class="container">
  <div class="row">
    <h4>Title</h4>
      <?php
        echo base64_decode($result->title);
      ?>
  </div>
  <div class="row">
    <h4>Summary</h4>
      <?php
        echo base64_decode($result->summary);
      ?>
  </div>
  <div class="row">
    <h4>References</h4>
      <?php
        echo base64_decode($result->reference);
      ?>
  </div>
  <div class="row">
    <h4>Category</h4>
      <?php
        echo $result->category;
      ?>
  </div>
</div>
@stop