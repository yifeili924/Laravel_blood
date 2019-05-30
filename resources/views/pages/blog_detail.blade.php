@extends('layouts.main')
@section('pageTitle', 'Bolgs')
@section('content')
    @include('partials.status-panel')
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
    <div class="about-section">
        <p class="caption text-center">BOLG</p>
        <div class="blog-content">
            <div class="container" style="clear: both;color: black;padding-bottom: 50px">

                <h3 style="border-bottom: 2px solid #eee;padding-bottom: 25px;text-align: center; "> <?php echo($blogs->page_title)?></h3>
                <div class="block"><img class="featured_image" src='{{ asset('featured/'.$blogs->image_link) }}'></div>

                <h3 style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> <?php echo($blogs->title)?></h3>
                <h4 class="block" style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> Summary</h4>
                <div class="block" style="border-bottom: 2px solid #eee;padding-bottom: 35px; "> <?php echo($blogs->summary)?></div>
                <h4 class="block" style="border-bottom: 2px solid #eee;padding-bottom: 25px; "> Description</h4>
                <div class="block" style="border-bottom: 2px solid #eee;padding-bottom: 35px; "> <?php echo($blogs->contents)?></div>

                @include('partials._comment', ['comments' => $blogs->comments, 'blog_id' =>  $blogs->id])

            </div>
        </div>
    </div>

    {{--<div class="red-rectangle"></div>--}}
@stop
