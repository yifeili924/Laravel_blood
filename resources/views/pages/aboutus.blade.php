@extends('layouts.main')
@section('pageTitle', 'About Us')
@section('content')
@include('partials.status-panel')

    <div class="about-section">
        <div class="container">
            <p class="caption text-center">Who we are</p>
            <p class="subcaption text-center">
                Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of
                passing the Fellowship of the Royal College of Pathologists (FRCPath) haematology exam. We are based in
                the UK and all content is provided by haematologists and scientists who have passed the exam.
            </p>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Dr Ali Mahdi</p>
                        <p class="prof">Consultant Haematologist and Blood Academy founder</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Pashtewan Agha</p>
                        <p class="prof">Technical operations Lead</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Steve Couzens (Reviewer)</p>
                        <p class="prof">Lead Clinical Scientist, University Hospital of Wales Immunophenotyping Laboratory</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Dr Nagah Elmusharaf</p>
                        <p class="prof">Consultant Haematologist, University Hospital of Wales</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Dr Paula Bolton-Maggs (Reviewer)</p>
                        <p class="prof">Consultant haematologist and former medical director of SHOT</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Dr Eamon Mahdi</p>
                        <p class="prof">Haematology trainee, University Hospital of Wales</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Dr Charles Percy</p>
                        <p class="prof">Consultant Haematologist (Haemostasis and Thrombosis), Queen Elizabeth Hospital, Birmingham</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="member">
                        {{--<div class="photo"></div>--}}
                        <p class="name">Dr Samya Obaji</p>
                        <p class="prof">Clinical research fellow in haemostasis and thrombosis, Cardiff University</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="objective">
                        There is obviously no substitute for a well-structured training scheme. However, getting
                        exposure to rare cases as well as developing and refining exam technique can be difficult. This
                        site aims to develop these skills and help equip you to pass the exam and develop a passion for
                        haematology that grows as an independent haematologist.
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="objective">
                        Blood-Academy aims to be the most comprehensive revision resource available. We are constantly
                        working on developing more content and because we are online we can be much more up-to-date than
                        any written text.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="red-rectangle"></div>--}}
@stop
