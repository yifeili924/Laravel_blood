@extends('layouts.main')

@section('head')
    {!! HTML::style('/assets/css/reset.css') !!}
@stop

@section('content')

        {!! Form::open(['url' => url('/password/email'), 'class' => 'form-signin' ] ) !!}

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h2 class="form-signin-heading">Password Reset</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input id="inputEmail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email address" autofocus required>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif


        <br />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Send me a reset link</button>

        {!! Form::close() !!}

@stop