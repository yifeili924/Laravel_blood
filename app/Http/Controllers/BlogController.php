<?php
/**
 * Created by PhpStorm.
 * User: iku
 * Date: 2019-03-09
 * Time: 6:51 PM
 */

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
class BlogController
{
    public function getBlog(Request $request){
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('panels.admin.blogs', ['blogs'=> $blogs]);

    }
    public function addBlog(Request $request){

        return view('panels.admin.addblog');

    }
    public function postBlog(Request $request){
        $image=$request->file('image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
//        $destination=asset('featured');
        $destination=public_path('/featured');
        $image->move($destination,$input['imagename']);
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->contents = $request->blog;
        $blog->summary = $request->summary;
        $blog->page_title = $request->page_title;
        $blog->image_link=$input['imagename'];
        $blog->save();
//        echo($request->blog);
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('panels.admin.blogs', ['blogs'=> $blogs]);

    }
    public function detailBlog($id){

        $blogs = Blog::find($id);

        return view('panels.admin.blog_detail', ['blogs'=> $blogs]);

    }
    public function deleteBlog($id){

        $blogs = Blog::find($id)->delete();
        return back();

    }
    public function editBlog($id){

        $blogs = Blog::find($id);
        return view('panels.admin.blog_edit', ['blogs'=> $blogs]);

    }
    public function updateBlog(Request $request){
        $id=$request->blog_id;
        $blog = Blog::find($id);
        $image=$request->file('image');
        if($image==''){
            $blog->title = $request->title;
            $blog->contents = $request->blog;
            $blog->summary = $request->summary;
            $blog->page_title = $request->page_title;
            $blog->save();
        }
        else{
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
//        $destination=asset('featured');
            $destination=public_path('/featured');
            $image->move($destination,$input['imagename']);
            $blog->title = $request->title;
            $blog->contents = $request->blog;
            $blog->summary = $request->summary;
            $blog->page_title = $request->page_title;
            $blog->image_link=$input['imagename'];
            $blog->save();
        }
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('panels.admin.blogs', ['blogs'=> $blogs]);
    }
}