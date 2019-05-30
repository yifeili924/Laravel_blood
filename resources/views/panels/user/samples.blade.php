@extends('layouts.sample')
@section('pageTitle', 'Sample Page')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="menu_box">
                    <h3 class="menu_title shadow">Part 1</h3>
                    <ul class="menu_nav">
                        <li>
                            <figure><img src="/assets/images/multi_choice.png" alt="Icon"></figure>
                            <span><a href="{{route('public.sample-mcq-emq' )}}">Multiple Choice and Extended Matching Questions</a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="menu_box min_height">
                    <h3 class="menu_title">Part 2</h3>
                    <ul class="menu_nav">
                        <li>
                            <figure><img src="/assets/images/morphology.png" alt="Icon"></figure>
                            <span><a href="{{route('public.sample-morphology' )}}">Morphology</a></span>
                        </li>
                        <li>
                            <figure><img src="/assets/images/transfusion.png" alt="Icon"></figure>
                            <span><a href="{{route('public.sample-transfusion' )}}">Transfusion</a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@stop