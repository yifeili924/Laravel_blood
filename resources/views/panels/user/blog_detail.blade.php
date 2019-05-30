@extends('layouts.user-dashboard')
@section('pageTitle', 'BLOG')
@section('content')
<style>
    .blog-content{
        background: #1a3a5e;
        min-height: calc(100vh - 176px);
        padding: 50px 30px 20px;
    }
    @media (max-width: 700px){
        .blog-content{
            padding: 30px 0px 20px;
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
    .block{
        margin-top: 20px;
    }
    .featured_image{
        width: 500px;
        height: 300px;
        display:block;
        margin:auto;

    }
</style>
    <div class="dashboard-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon mobile_show"></span>
                Blog Detail
            </p>
        </div>
        <div class="blog-content">
            <div class="container" style="clear: both;color: white">


                <h3 style="border-bottom: 2px solid #eee;padding-bottom: 25px;text-align: center; "> <?php echo($blogs->page_title)?></h3>
                <div class="block"><img class="featured_image" src='{{ asset('featured/'.$blogs->image_link) }}'></div>

                <h3 style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> <?php echo($blogs->title)?></h3>
                <h4 class="block" style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> Summary</h4>
                <div class="block" style="border-bottom: 2px solid #eee;padding-bottom: 35px; "> <?php echo($blogs->summary)?></div>
                <h4 class="block" style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> Description</h4>
                <div class="block" style="border-bottom: 2px solid #eee;padding-bottom: 35px; "> <?php echo($blogs->contents)?></div>

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
        </div>
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
