@extends('layouts.main')

@section('head')

@stop

@section('content')

<div class="row">
    <div class="col-md-6">
      <table class="table">
          <thead>
            <tr>
              <th>Part 1</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="{{route('admin.mcq-emq')}}"> MCQs, EMQs </a></td>
            </tr>
            <tr>
              <td><a href="{{route('admin.essay-questions')}}"> Essay questions </a></td>
            </tr>
          </tbody>
        </table>
    </div>
    <div class="col-md-6">
      <table class="table">
          <thead>
            <tr>
              <th>Part 2</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="{{route('admin.morphology')}}"> Morphology </a></td>
            </tr>
            <tr>
              <td><a href="{{route('admin.quality-assurance')}}"> Quality assurance </a></td>
            </tr>
            <tr>
              <td><a href="{{route('admin.transfusion')}}"> Transfusion </a></td>
            </tr>
          </tbody>
        </table>
    </div>
  </div>    

@stop