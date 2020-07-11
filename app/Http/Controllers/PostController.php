<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(array('auth'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //for pagination
        //$posts = Post::all();
        //$posts = Post::paginate(3);
        $posts = Post::paginate(3);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $rules=[
            'title'=>'required',
            'body'=>'required',
        ];
        $messages=[
            'title.required'=>'This title field is required',
            'body.required'=>'This :attribute field is required'
        ];
        $this->validate($request,$rules,$messages);

        //check image
        $filename="";
        if($request->hasFile('postImage') && $request->postImage->isValid())
        {
            $extenstion = $request->postImage->extension();
            $filename = time()."_.".$extenstion;
            $request->postImage->move(public_path('images'),$filename);
        }

        $posts = Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>1,
            'post_image'=>$filename
        ]);
        if($posts)
        {
            //return redirect('posts')->with('success_message','Post successfully created.');
            session()->flash('success_message','Post successfully created.');
            return redirect('posts');
        }
        else
        {
            //return redirect('posts')->with('error_message','Problem try again!');
            session()->flash('error_message','Problem try again!');
            return redirect('posts');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
       $post = Post::find($post->id);
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //validation
        $rules=[
            'title'=>'required',
            'body'=>'required',
        ];
        $messages=[
            'title.required'=>'This title field is required',
            'body.required'=>'This :attribute field is required'
        ];
        $this->validate($request,$rules,$messages);

        $posts = Post::find($post->id)->update([
            'title' => $request->title,
            'body'  => $request->body
        ]);
        if($post)
        {
           return redirect('posts')->with('success_message','Post successfully updated.'); 
        }
        else
        {
            return redirect('posts')->with('error_message','Problem try again!');
        }
        /*$post   = Post::find($post->id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post = $post->save();
        if($post)
        {
           return redirect('posts')->with('success_message','Post successfully updated.'); 
        }
        else
        {
            return redirect('posts')->with('error_message','Problem try again!');
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post   = Post::find($id);
        $delete = $post->delete();
        if($delete)
        {
            return redirect('posts')->with('success_message','Post Deleted Successfully');
        }
    }

    public function csv()
    {
        return view('posts.upload_file');
    }

    public function uploadFile(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        echo "<pre>";print_r($data);die;
    }
}
