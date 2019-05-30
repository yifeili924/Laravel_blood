@extends('layouts.main')
@section('pageTitle', 'Contact Us')
@section('content')
@include('partials.status-panel')
 <!-- banner-part-start-->
    <div class="contact-section">
        <div class="contact-form">
            @if (Session::has('message'))
                <div class="alert alert-info" style="color: green; text-align: center;">
                    {{ Session::get('message') }}
                </div>
            @endif

            <h2 align="center">We’d love to hear from you</h2>

            {!! Form::open(['url' => url('contact-page'), 'class' => 'form-signin', 'data-parsley-validate']) !!}
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" value="" placeholder="Email address" required>
                <!-- <input type="text" name="phone" value="" placeholder="Phone number" required> -->
                <textarea placeholder="Message" name="Your Message" rows="6"></textarea>
                <button type="submit" class="btn-block">Send</button>
            {!! Form::close() !!}
        </div>
    </div>

    {{--<div class="red-rectangle"></div>--}}

@stop
