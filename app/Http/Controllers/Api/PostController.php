<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Validator;
use Illuminate\Support\Facades\Auth; 

class PostController extends Controller
{
	public $successStatus = 200;
	
	public function allPosts()
	{
		return Post::all();
	}

    public function save(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
            'title' => 'required', 
            'body' => 'required',
            'user_id'=>'required'
        ],
        [
        	'title.required' 		=> 'Please enter title',
        	'body.required'		=> 'Please enter description',
        	'user_id.required'			=> 'Please enter user id',
        ]
    	);
    	if ($validator->fails()) { 
			return response()->json(['error'=>$validator->errors()], 401);            
		}

		$filename="";
        if($request->hasFile('image') && $request->image->isValid())
        {
            $extenstion = $request->image->extension();
            $filename = time()."_.".$extenstion;
            $request->image->move(public_path('images'),$filename);
        }

		$posts = Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_id'=>$request->user_id,
            'post_image'=>$filename,
        ]);

		$success["message"]="Post created successfully";
		$success["status"]=true;
        if($posts)
        {
           	return response()->json(['success'=>$success], $this->successStatus);
        }
        else
        {
        	$error['status']=false;
        	$error["message"]="Try again!";
          	return response()->json(['error'=>$error], 401);
        }
    }

    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
            'id' => 'required', 
            'title' => 'required',
            'body' => 'required',
        ],
        [
        	'id.required'    => 'Please enter title',
        	'title.required' => 'Please enter title',
        	'body.required'	 => 'Please enter description',
        ]
    	);
    	if ($validator->fails()) { 
			return response()->json(['error'=>$validator->errors()], 401);            
		}

		$post = Post::find($request->id)->update([
            'title' => $request->title,
            'body'  => $request->body
        ]);
        if($post)
        {
        	$success["message"]="Post updated successfully";
			$success["status"]=true;
         	return response()->json(['success'=>$success], $this->successStatus);
        }
        else
        {
            $error['status']=false;
        	$error["message"]="Try again!";
          	return response()->json(['error'=>$error], 401);
        }
    }

    public function delete(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
            'id' => 'required',
        ],
        [
        	'id.required'    => 'Please enter id',
        ]
    	);
    	if ($validator->fails()) { 
			return response()->json(['error'=>$validator->errors()], 401);            
		}

    	$post   = Post::find($request->id);
        $delete = $post->delete();
        if($delete)
        {
            $success["message"]="Post deleted successfully";
			$success["status"]=true;
         	return response()->json(['success'=>$success], $this->successStatus);
        }
    }

    public function show($id)
    {
    	$post = Post::find($id);
    	if($post)
    	{
    		$data["status"]=$post['id'];
    		$data["title"]=$post['title'];
    		$data["body"]=$post['body'];
    		$data["user_id"]=$post['user_id'];
    		$data["post_image"]=$post['post_image'];
    		$data["created_at"]=$post['created_at'];
        	return response()->json(['status'=>true,'result'=>$data], $this->successStatus);
    	}
    	else
    	{
    		$error['status']=false;
        	$error["message"]="Data not available";
          	return response()->json(['status'=>false,'error'=>$error], 401);
    	}
    }

    public function searchPosts(Request $request)
    {
    	$data = $request->get('filter_text');

        $searchPosts = Post::where('title', 'like', "%{$data}%")
                         ->orWhere('body', 'like', "%{$data}%")
                         ->get();
        return response()->json(['status'=>true,'result'=>$searchPosts], $this->successStatus); 
    }


}
