@extends('layouts.user-page')
@section('pageTitle', 'Summary Tables & Figures')

@section('content')
@include('partials.status-panel')

    <div class="panel-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon"></span>
                Interactive modules
            </p>
        </div>
        <div class="page-content">
            <div class="subtitle text-center">
                {{ $mod_title }}
            </div>

            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom: 30px">
                <iframe style="width: 100%" src="https://s3.eu-west-2.amazonaws.com/bamodules/{{$mod_folder}}/{{ $mod_name }}"></iframe>
            </div>

            <a href="{{ route('subscription.interactive-modules') }}" class="link-primary">Return</a>
        </div>
    </div>
@stop

