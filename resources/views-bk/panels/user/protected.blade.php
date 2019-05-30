@extends('layouts.main')

@section('head')

@stop

@section('content')
 <div class="container">
      <div class="section_full_rw padding_tp-botm wp100">
        <div class="memer_home">
          <div class="Essay_bx">
            <div class="contents_left">
              <h2>Part 1</h2>
              <span><a href="{{route('subscription.exam', ['type'=>'mcq-emq'] )}}">MCQs, EMQs</a></span> 
              <span><a href="{{route('subscription.exam', ['type'=>'essay-questions'] )}}">Essay questions</a></span> </div>
          </div>
          <div class="Essay_bx">
            <div class="contents_left">
              <h2>Part 2</h2>
              <span><a href="{{route('subscription.exam', ['type'=>'morphology'] )}}">Morphology</a></span> 
              <span><a href="{{route('subscription.exam', ['type'=>'quality-assurance'] )}}">Quality assurance</a></span> 
              <span><a href="{{route('subscription.exam', ['type'=>'transfusion'] )}}">Transfusion</a></span> </div>
          </div>
        </div>
        <div class="myaccount_se">
          <!-- <ul>
            <li><a href="MCQandEMQs.html">MCQs, EMQs</a></li>
            <li><a href="MCQ-EMQquestion-page.html">Essay questions</a></li>
          </ul> -->
        </div>
      </div>
    </div>
   
@stop