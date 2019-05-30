@extends('layouts.user-page')
@section('pageTitle', 'Summary Tables & Figures')

@section('content')
    @include('partials.status-panel')
    <style>
        .comment_part {
            margin-left: 50px;
        }

        @media (max-width: 700px) {
            .comment_part {
                margin-left: 15px;
            }
        }

    </style>
    <div class="panel-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon"></span>
                Summary Tables & Figures
            </p>
        </div>
        <div class="page-content">
            <div class="subtitle text-center">
                {{ $figure->title }}
            </div>

            <div class="text-center" style="margin-bottom: 30px">
                <img src="https://s3.eu-west-2.amazonaws.com/{{ $figure->bucket_name }}/{{ $figure->figureid }}"/>
            </div>

            <a href="{{ route('subscription.hubfigures') }}" class="link-primary">Return</a>

            @include('partials._comment_figure', ['comments' => $figure->comments, 'figure_id' =>  $figure->figureid])

            <h3 style="margin-top: 30px;margin-bottom: 30px">Add comment</h3>
            {!! Form::open(['url' => route('add_comment_to_figure')] ) !!}

            <div class="form-group">
                <textarea name="comment_body" class="form-control" style="height: 100px"></textarea>
                <input type="hidden" name="figure_id" value="{{ $figure->id }}"/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Add Comment"/>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        function addReply(comment_id) {
            var reply = document.getElementById("reply_" + comment_id);
            if (reply.style.display == 'none') {
                document.getElementById("reply_" + comment_id).style.display = "block";
            }
            else {
                document.getElementById("reply_" + comment_id).style.display = "none";
            }

        }
    </script>
@stop

