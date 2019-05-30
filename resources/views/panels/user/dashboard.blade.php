@extends('layouts.user-dashboard')
@section('pageTitle', 'Home Page')

@section('content')

    <div class="dashboard-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon mobile_show"></span>
                Dashboard
            </p>
        </div>
        <div class="page-content">
            <p class="subtitle">Welcome to Blood Academy</p>
            <div class="row no-padding">
            <div class="row">
                <div class="col-sm-6">
                    <div class="menu_box">
                        <div class="menu_title shadow">Resource Hub</div>
                        <ul class="menu_nav">
                            <li>
                                <figure><img src="{{ asset('assets/images/interactive.png')}}" alt="Icon"></figure>
                                <span><a href="{{ route('subscription.icases') }}">Interactive Cases</a></span>
                            </li>
                            <li>
                                <figure><img src="{{ asset('assets/images/morphology.png')}}" alt="Icon"></figure>
                                <span><a href="{{ route('subscription.hubslides') }}">Morphology Cases</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.hubfigures') }}">
                                        <img src="{{ asset('assets/images/entry2.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.hubfigures') }}">Summary Tables & Figures</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.guidelines') }}">
                                        <img src="{{ asset('assets/images/entry3.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.guidelines') }}">Guideline summaries</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.interactive-modules') }}">
                                        <img src="{{ asset('assets/images/entry4.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.interactive-modules') }}">Interactive modules</a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="menu_box {{$limited ? 'disabled' : ''}}">
                        <div class="menu_title shadow">Part 1</div>
                        <ul class="menu_nav">
                            <li>
                                <figure>
                                    <a href="{{route('subscription.exam-mcq-emq-opt' )}}">
                                        <img src="{{ asset('assets/images/multi_choice.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{route('subscription.exam-mcq-emq-opt' )}}">Multiple Choice and Extended Matching Questions</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.exam-essay-questions') }}">
                                        <img src="{{ asset('assets/images/essay.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.exam-essay-questions') }}">Essay</a></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="menu_box {{$limited ? 'disabled' : ''}}">
                        <div class="menu_title shadow">Part 2</div>
                        <ul class="menu_nav">
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.exam-morphology' )}}">
                                        <img src="{{ asset('assets/images/morphology.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.exam-morphology' )}}">Morphology</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.exam-quality-assurance') }}">
                                        <img src="{{ asset('assets/images/labotoryquality.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.exam-quality-assurance') }}">Laboratory Quality Assurance (Including Interactive Module)</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.exam-transfusion') }}">
                                        <img src="{{ asset('assets/images/transfusion.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span><a href="{{ route('subscription.exam-transfusion') }}">Transfusion</a></span>
                            </li>
                            <li>
                                <figure>
                                    <a href="{{ route('subscription.exam-haemothromb') }}">
                                        <img src="{{ asset('assets/images/haemostasis.png')}}" alt="Icon">
                                    </a>
                                </figure>
                                <span>
                                    <a href="{{ route('subscription.exam-haemothromb') }}">Haemostasis and thrombosis</a>
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="menu_box {{$limited ? 'disabled' : ''}}">
                        <div class="menu_title shadow">Track my progress</div>
                        <ul class="menu_nav">
                            <li>
                                <a href="{{ route('subscription.analytics') }}">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                             aria-valuemin="0" aria-valuemax="100" style="width:100%"> Click here
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu_box">
                        <div class="menu_title shadow">Updates ...</div>
                        <ul class="ref">
                            @foreach($updates as $update)
                                <li><?php echo base64_decode($update->updates)?> </li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="link-feedback right-floated" data-toggle="modal" data-target="#fbModal" type="button" style="margin-bottom: 20px;"> Feedback </button>
                </div>
            </div>
            </div>
        </div>
    </div>
@stop
