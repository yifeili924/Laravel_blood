@extends('layouts.main')

@section('head')
    {!! HTML::style('/assets/css/register.css') !!}
    {!! HTML::style('/assets/css/parsley.css') !!}
@stop

@section('content')

        {!! Form::open(['url' => url('register'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}

        @include('includes.errors')

        <h2 class="form-signin-heading">Please register</h2>

        <label for="inputEmail" class="sr-only">Email address</label>
        {!! Form::email('email', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Email address',
            'required',
            'id'                            => 'inputEmail',
            'data-parsley-required-message' => 'Email is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'email'
        ]) !!}

        <label for="inputFirstName" class="sr-only">Name</label>
        {!! Form::text('first_name', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Name',
            'required',
            'id'                            => 'inputFirstName',
            'data-parsley-required-message' => 'Name is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}

        <label for="inputFirstName" class="sr-only">Username</label>
        {!! Form::text('username', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Username',
            'required',
            'id'                            => 'inputUsername',
            'data-parsley-required-message' => 'Username is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}

        <label for="inputFirstName" class="sr-only">City</label>
        {!! Form::text('city', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'City',
            'required',
            'id'                            => 'inputCity',
            'data-parsley-required-message' => 'City is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}

        <label for="inputFirstName" class="sr-only">Country</label>
        {!! Form::text('country', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Country',
            'required',
            'id'                            => 'inputCountry',
            'data-parsley-required-message' => 'Country is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}

        <label for="inputCurrenthospital" class="sr-only">Current hospital</label>
        {!! Form::text('current_hospital', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Current hospital',
            'required',
            'id'                            => 'inputCurrenthospital',
            'data-parsley-required-message' => 'Current hospital is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}

        <label for="inputCountryresidence" class="sr-only">Country of residence</label>
        {!! Form::text('country_residence', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Country of residence',
            'required',
            'id'                            => 'inputCountryresidence',
            'data-parsley-required-message' => 'Country of residence is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}

        <label for="inputHaematology" class="sr-only">Haematology trainee/ scientist</label>
        {!! Form::text('haematology', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Haematology trainee/ scientist',
            'required',
            'id'                            => 'inputHaematology',
            'data-parsley-required-message' => 'Haematology trainee/ scientist is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '32'
        ]) !!}


        <label for="inputPassword" class="sr-only">Password</label>
        {!! Form::password('password', [
            'class'                         => 'form-control',
            'placeholder'                   => 'Password',
            'required',
            'id'                            => 'inputPassword',
            'data-parsley-required-message' => 'Password is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-minlength'        => '6',
            'data-parsley-maxlength'        => '20'
        ]) !!}


        <label for="inputPasswordConfirm" class="sr-only has-warning">Confirm Password</label>
        {!! Form::password('password_confirmation', [
            'class'                         => 'form-control',
            'placeholder'                   => 'Password confirmation',
            'required',
            'id'                            => 'inputPasswordConfirm',
            'data-parsley-required-message' => 'Password confirmation is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-equalto'          => '#inputPassword',
            'data-parsley-equalto-message'  => 'Not same as Password',
        ]) !!}

        <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>

        <button class="btn btn-lg btn-primary btn-block register-btn" type="submit">Register</button>

        <p class="or-social"></p>

        <!-- @include('partials.socials') -->

        {!! Form::close() !!}


@stop

@section('footer')

    <script type="text/javascript">
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<span class="error-text"></span>',
            classHandler: function (el) {
                return el.$element.closest('input');
            },
            successClass: 'valid',
            errorClass: 'invalid'
        };
    </script>

    {!! HTML::script('/assets/plugins/parsley.min.js') !!}

    <script src='https://www.google.com/recaptcha/api.js'></script>

@stop