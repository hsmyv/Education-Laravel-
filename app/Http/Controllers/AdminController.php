<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Course;
use App\Models\Comment;
use App\Models\AboutInformations;
use Input;
class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index', [
            'users' => User::all(),
            'courses' => Course::latest()->take(5)->get()
        ]);
    }
    public function post_comments()
    {
        return view('admin.reviews.post-comments', ['comments' => Comment::latest()->get()]);
    }
     public function courses()
    {
        return view('admin.courses.courses', ['courses' => Course::all()]);
    }
       public function messages()
    {
        return view('admin.mail.messages');
    }
       public function activity()
    {
        return view('admin.profile.activity');
    }
       public function profile()
    {
        $user = Auth()->user();
        return view('admin.profile.profile', ['user' => $user]);
    }
    public function create_course()
    {
        return view('admin.courses.create-course');
    }

    public function create_post()
    {
        return view('admin.blog.create-post');
    }
      public function edit_post(Post $post)
    {
        return view('admin.blog.edit-post', ['post' => $post]);
    }

    public function posts(Post $post)
    {
       return view('admin.blog.posts', ['post' => $post, 'posts' => Post::all()]);
    }
    public function edit_about()
    {
        $information = AboutInformations::where('id', 1)->first();
        return view('admin.edit.about' ,['information' => $information]);
    }
    public function edit_about_informations(Request $request, AboutInformations $aboutInformations)
    {
        //$form = request()->all();
       // $form = request()->except(['_token', 'image']);


         $form = $request->validate([
                'slot1_title'               => 'required',
                'slot1_description'         => 'required',
                'slot2_title'               => 'required',
                'slot2_description'         => 'required',
                'slot3_title'               => 'required',
                'slot3_description'         => 'required',
                'picture_title'             => 'required',
                'picture_body'              => 'required',
                'video_title'               => 'required',
                'video_description'         => 'required',
                'video_slot1_title'         => 'required',
                'video_slot1_description'   => 'required',
                'video_slot2_title'         => 'required',
                'video_slot2_description'   => 'required',
                'video_slot3_title'         => 'required',
                'video_slot3_description'   => 'required',
                'video_slot4_title'         => 'required',
                'video_slot4_description'   => 'required',
            ]);

             if($request->hasFile('image')){
                    $aboutInformations->addMediaFromRequest('image')
                    ->usingName('about')
                    ->toMediaCollection('images');
                }

        AboutInformations::where('id', 1)->update($form);


        return back();
    }
}
