@extends('layouts.user-page')
@section('pageTitle', 'Analytics')

@section('content')
    <div class="panel-content analytic-panel">
        <div class="page-title shadow">
            <p>

                <span onclick="openNav()" class="fa fa-navicon"></span>
                Analytics

                <a class="link-reset" href="{{route('user.reset-stats')}}">Reset all questions&nbsp;<i class="fa fa-angle-double-right"></i></a>

            </p>
        </div>
        <div class="page-content">
            <div class="subtitle">Part 1</div>
            <div class="test-type flexDiv">
                <div class="test-icon">
                    <img src="{{ asset('assets/images/multi_choice.png') }}">
                </div>
                <div class="test-title">
                    <p>Multiple choice and extended matched questions</p>
                    <div class="flexDiv desktop_flex_show">
                        <span class="correct-mark"></span><span>Correct</span>
                        <span class="incorrect-mark"></span><span>Incorrect</span>
                    </div>
                </div>
            </div>
            <div class="flexDiv mobile_flex_show">
                <span class="correct-mark"></span><span>Correct</span>
                <span class="incorrect-mark"></span><span>Incorrect</span>
            </div>
            <div class="test-result">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                         aria-valuemin="0" aria-valuemax="100" style="width:{{$perc}}%">
                        {{$perc}}%
                    </div>
                </div>
            </div>
            <div class="test-actions">
                <a class="link-primary" style="margin-right: 30px; margin-bottom: 15px" href="{{route('user.reviewinc')}}">Review incorrect answers &nbsp;<i class="fa fa-angle-double-right"></i></a>
                {{--<a class="link-reset" href="{{route('user.reset-stats')}}">Reset &nbsp;<i class="fa fa-angle-double-right"></i></a>--}}
            </div>

            <div class="subtitle">Part 2</div>
            <div class="test-type flexDiv">
                <div class="test-icon">
                    <img src="{{ asset('assets/images/morphology.png') }}">
                </div>

                <div class="flexDiv" style="justify-content: space-between; flex-wrap: wrap; width: 100%;">
                    <div class="test-title">
                        <p>Morphology</p>
                        <div class="flexDiv desktop_flex_show">
                            <span class="correct-mark"></span><span>Viewed</span>
                            <span class="incorrect-mark"></span><span>Not Viewed</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flexDiv mobile_flex_show">
                <span class="correct-mark"></span><span>Viewed</span>
                <span class="incorrect-mark"></span><span>Not Viewed</span>
            </div>
            <div class="test-result">
                <div class="res-block">
                    <p>{{count($morphs)}} - Cases</p>
                    <div class="cases">
                        @foreach ($morphs as $morph)
                            @if($morph['seen'])
                                <div class="case-item" style="background-color: #95c123"><a href="/user/getquestion/morph/{{$morph['id']}}"><p>{{$morph['id']}}</p></a></div>
                            @endif
                            @if(!$morph['seen'])
                                <div class="case-item"><a href="/user/getquestion/morph/{{$morph['id']}}"><p>{{$morph['id']}}</p></a></div>
                            @endif
                        @endforeach
                    </div>
                    {{--<p>Long cases</p>--}}
                    {{--<div class="cases">--}}
                        {{--@for ($i=0; $i < 48; $i++)--}}
                            {{--<div class="case-item"><p>12</p></div>--}}
                        {{--@endfor--}}
                    {{--</div>--}}
                </div>
            </div>

            <div class="test-type flexDiv">
                <div class="test-icon">
                    <img src="{{ asset('assets/images/transfusion.png') }}">
                </div>
                <div class="flexDiv" style="justify-content: space-between; flex-wrap: wrap; width: 100%;">
                    <div class="test-title">
                        <p>Transfusion</p>
                        <div class="flexDiv desktop_flex_show">
                            <span class="correct-mark"></span><span>Viewed</span>
                            <span class="incorrect-mark"></span><span>Not Viewed</span>
                        </div>
                    </div>
                    <div style="align-self: flex-end; margin-top: 15px;">
                        {{--<a class="link-reset">Reset &nbsp;<i class="fa fa-angle-double-right"></i></a>--}}
                    </div>
                </div>
            </div>
            <div class="flexDiv mobile_flex_show">
                <span class="correct-mark"></span><span>Viewed</span>
                <span class="incorrect-mark"></span><span>Not Viewed</span>
            </div>
            <div class="test-result">
                <div class="res-block">
                    <p>{{count($transfusions)}} - Cases</p>
                    <div class="cases">
                        @foreach ($transfusions as $morph)
                            @if($morph['seen'])
                                <div class="case-item" style="background-color: #95c123"><a href="/user/getquestion/trans/{{$morph['id']}}"><p>{{$morph['id']}}</p></a></div>
                            @endif
                            @if(!$morph['seen'])
                                <div class="case-item"><a href="/user/getquestion/trans/{{$morph['id']}}"><p>{{$morph['id']}}</p></a></div>
                            @endif
                        @endforeach
                    </div>
                    {{--<p>Long cases</p>--}}
                    {{--<div class="cases">--}}
                        {{--@for ($i=0; $i < 48; $i++)--}}
                            {{--<div class="case-item"><p>12</p></div>--}}
                        {{--@endfor--}}
                    {{--</div>--}}
                </div>
            </div>

            <div class="test-type flexDiv">
                <div class="test-icon">
                    <img src="{{ asset('assets/images/haemostasis.png') }}">
                </div>

                <div class="flexDiv" style="justify-content: space-between; flex-wrap: wrap; width: 100%;">
                    <div class="test-title">
                        <p>Haemostasis and thrombosis</p>
                        <div class="flexDiv desktop_flex_show">
                            <span class="correct-mark"></span><span>Viewed</span>
                            <span class="incorrect-mark"></span><span>Not Viewed</span>
                        </div>
                    </div>
                    <div style="align-self: flex-end; margin-top: 15px;">
                        {{--<a class="link-reset">Reset &nbsp;<i class="fa fa-angle-double-right"></i></a>--}}
                    </div>
                </div>
            </div>
            <div class="flexDiv mobile_flex_show">
                <span class="correct-mark"></span><span>Viewed</span>
                <span class="incorrect-mark"></span><span>Not Viewed</span>
            </div>
            <div class="test-result">
                <div class="res-block">
                    <p>{{ count($haemos) }} - Cases</p>
                    <div class="cases">
                        @foreach ($haemos as $morph)
                            @if($morph['seen'])
                                <div class="case-item" style="background-color: #95c123"><a href="/user/getquestion/haemo/{{$morph['id']}}"><p>{{$morph['id']}}</p></a></div>
                            @endif
                            @if(!$morph['seen'])
                                <div class="case-item"><a href="/user/getquestion/haemo/{{$morph['id']}}"><p>{{$morph['id']}}</p></a></div>
                            @endif
                        @endforeach
                    </div>
                    {{--<p>Long cases</p>--}}
                    {{--<div class="cases">--}}
                        {{--@for ($i=0; $i < 48; $i++)--}}
                            {{--<div class="case-item"><p>12</p></div>--}}
                        {{--@endfor--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@stop
