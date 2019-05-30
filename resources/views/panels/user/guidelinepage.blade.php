@extends('layouts.user-page')
@section('pageTitle', 'Guideline Summary')

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
                Guideline Summary
            </p>
        </div>
        <div class="page-content">
            <div class="subtitle"><?php echo base64_decode($figure->title); ?></div>

            <div class="guidebox">
                <?php echo base64_decode($figure->summary); ?>
            </div>

            <div class="menu_box">
                <h3 class="menu_title shadow">References</h3>
                <ul class="ref">
                    <?php echo base64_decode($figure->reference); ?>
                </ul>
            </div>

            <a class="link-primary" href="{{ route('subscription.guidelines') }}">Return</a>

            @include('partials._comment_guidline', ['comments' => $figure->comments, 'figure_id' =>  $figure->id])

            <h3 style="margin-top: 30px;margin-bottom: 30px">Add comment</h3>
            {!! Form::open(['url' => route('add_comment_to_guidline')] ) !!}

            <div class="form-group">
                <textarea name="comment_body" class="form-control" style="height: 100px"></textarea>
                <input type="hidden" name="guidline_id" value="{{ $figure->id }}"/>
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
