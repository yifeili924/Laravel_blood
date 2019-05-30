<?php
/**
 * Created by PhpStorm.
 * User: iku
 * Date: 2019-03-11
 * Time: 9:50 AM
 */

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Icomment;
use Illuminate\Http\Request;
use App\Events\StatusLiked;
use App;
use App\Mcase;
use App\TablesFigures;
use App\Guideline;

class CommentController
{
    public function addComment(Request $request)
    {
        $comment = new Icomment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $blog = Blog::find($request->get('blog_id'));
        $blog->comments()->save($comment);

        return back();

    }

    public function replyComment(Request $request)
    {
        $reply = new Icomment();
        $comment_content = $request->get('comment_body');
        $reply->body = $comment_content;
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $blog_id = $request->get('blog_id');
        $post = Blog::find($blog_id);
        $post->comments()->save($reply);

        $reply_user_id = Icomment::find($request->get('comment_id'))->user_id;

        $comment_data = [
            'blogid' => $blog_id,
            'commentid' => $reply->id,
            'content' => $comment_content,
            'time' => $reply->created_at,
            'sample_type' => "blog",
            'seen' => "0"
        ];

        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->add_comment_to_user($firebase, $reply_user_id, $comment_data);
        return back();

    }

    public function viewComments($id)
    {        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $comments = $fb->read_comments($firebase, $id);
//        print_r($comments);
//        echo $comments;
        return view('panels.user.comments', ['comments' => $comments]);
    }

    public function addCommentToMorphology(Request $request)
    {
        $comment = new Icomment;
        $comment->body = $request->get('comment_body');
        $comment->sample_type = $request->get('sample_type');
        $comment->user()->associate($request->user());
        $morph = Mcase::find($request->get('morph_id'));
        $morph->comments()->save($comment);

        return back();

    }

    public function replyMorphComment(Request $request)
    {
        $reply = new Icomment();
        $reply->body = $request->get('comment_body');
        $reply->sample_type = $request->get('sample_type');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Mcase::find($request->get('morph_id'));
        $post->comments()->save($reply);

        $reply_user_id = Icomment::find($request->get('comment_id'))->user_id;

        $comment_data = [
            'blogid' => $request->get('morph_id'),
            'commentid' => $reply->id,
            'content' => $request->get('comment_body'),
            'time' => $reply->created_at,
            'sample_type' => $request->get('sample_type'),
            'seen' => "0"
        ];

        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->add_comment_to_user($firebase, $reply_user_id, $comment_data);
        return back();

    }

    public function addCommentToFigure(Request $request)
    {
        $comment = new Icomment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $figure = TablesFigures::find($request->get('figure_id'));
        $figure->comments()->save($comment);

        return back();

    }

    public function replyFigureComment(Request $request)
    {
        $reply = new Icomment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = TablesFigures::find($request->get('figure_id'));
        $post->comments()->save($reply);

        $reply_user_id = Icomment::find($request->get('comment_id'))->user_id;

        $comment_data = [
            'blogid' => $request->get('figure_id'),
            'commentid' => $reply->id,
            'content' => $request->get('comment_body'),
            'time' => $reply->created_at,
            'sample_type' => "figure",
            'seen' => "0"
        ];

        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->add_comment_to_user($firebase, $reply_user_id, $comment_data);
        return back();

    }

    public function addCommentToGuidline(Request $request)
    {
        $comment = new Icomment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $guideline = Guideline::find($request->get('guidline_id'));
        $guideline->comments()->save($comment);

        return back();
//        echo ($request->get('guidline_id'));


    }

    public function replyGuidlineComment(Request $request)
    {
        $reply = new Icomment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Guideline::find($request->get('guidline_id'));
        $post->comments()->save($reply);

        $reply_user_id = Icomment::find($request->get('comment_id'))->user_id;

        $comment_data = [
            'blogid' => $request->get('guidline_id'),
            'commentid' => $reply->id,
            'content' => $request->get('comment_body'),
            'time' => $reply->created_at,
            'sample_type' => "guidline",
            'seen' => "0"
        ];

        // create the object of FB
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $fb->add_comment_to_user($firebase, $reply_user_id, $comment_data);
        return back();
    }

}