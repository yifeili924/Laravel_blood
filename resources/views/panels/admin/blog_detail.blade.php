@extends('layouts.admin')

@section('head')

@stop

@section('content')
    <style>
        .blog-content{
            min-height: calc(100vh - 176px);
            padding: 0px 30px 20px;
        }
        @media (max-width: 700px){
            .blog-content{
                padding: 0px 0px 20px;
            }
        }
        .comment_part{
            margin-left: 50px;
        }
        @media (max-width: 700px){
            .comment_part{
                margin-left: 15px;
            }
        }
        .featured_image{
            width: 500px;
            height: 300px;
            display:block;
            margin:auto;

        }
    </style>

            <h3 style="float: left;">Blog Detail</h3>
            <a href="{{ route('admin.add_bolg') }}" style="text-decoration: none;float: right;margin-top: 15px;margin-right: 30px" class="btn btn-primary">Add Blog</a>
            <hr style="clear: both;"/>
        <div class="container" style="clear: both;">

            <h3 style="border-bottom: 2px solid #eee;padding-bottom: 25px;text-align: center; "> <?php echo($blogs->page_title)?></h3>
            <div><img class="featured_image" src='{{ asset('featured/'.$blogs->image_link) }}'></div>

            <h3 style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> <?php echo($blogs->title)?></h3>
            <h4 style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> Summary</h4>
            <div style="border-bottom: 2px solid #eee;padding-bottom: 35px; "> <?php echo($blogs->summary)?></div>
            <h4 style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> Description</h4>
            <div style="border-bottom: 2px solid #eee;padding-bottom: 35px; "> <?php echo($blogs->contents)?></div>

            @include('partials._comment_replies', ['comments' => $blogs->comments, 'blog_id' =>  $blogs->id])

            <h3 style="margin-top: 30px;margin-bottom: 30px">Add comment</h3>
            {!! Form::open(['url' => route('add_comment')] ) !!}

            <div class="form-group">
                <textarea name="comment_body" class="form-control" style="height: 100px"></textarea>
                <input type="hidden" name="blog_id" value="{{ $blogs->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Add Comment" />
            </div>
            {!! Form::close() !!}

        </div>

    <script>
        function addReply(comment_id) {
            var reply=document.getElementById("reply_"+comment_id);
            if (reply.style.display=='none'){
                document.getElementById("reply_"+comment_id).style.display =  "block";
            }
            else{
                document.getElementById("reply_"+comment_id).style.display =  "none";
            }

        }
    </script>

@stop