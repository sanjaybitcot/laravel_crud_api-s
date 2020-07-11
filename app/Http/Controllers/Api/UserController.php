<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /** 
	* login api 
	* 
	* @return \Illuminate\Http\Response 
	*/ 
    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
            'email' => 'required|email', 
            'password' => 'required',
        ],
        [
        	'name.required' 		=> 'Please enter name',
        	'email.required'		=> 'Please enter email',
        	'email.email'			=> 'Please enter valid email address',
        	'password.required'		=> 'Please enter password',
        ]
    	);
    	if ($validator->fails()) { 
			return response()->json(['error'=>$validator->errors()], 401);            
		}

	    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
	        $user = Auth::user(); 
	        $success['token'] =  $user->createToken('MyApp')->accessToken;
	        return response()->json(
	        	[
	        		'success' => $success
	        	], $this->successStatus); 
	    } 
	    else
	    { 
	        return response()->json(['error'=>'Unauthorized details'], 401); 
	    } 
    }

    public function logoutApi(Request $request)
	{
	    $request->user()->token()->revoke();
	    return response()->json([
	    	'status' => true,
	        'message' => 'Successfully logged out'
	    ]);
	}

    /** 
	* Register api 
	* 
	* @return \Illuminate\Http\Response 
	*/ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ],
        [
        	'name.required' 		=> 'Please enter name',
        	'email.required'		=> 'Please enter email',
        	'email.email'			=> 'Please enter valid email address',
        	'password.required'		=> 'Please enter password',
        	'c_password.required'	=> 'Please enter confirm password',
        	'c_password.same' 		=> 'Please enter same password',
        ]
    	);
		if ($validator->fails()) { 
			return response()->json(['error'=>$validator->errors()], 401);            
		}

		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name']  =   $user->name;
		return response()->json(['success'=>$success], $this->successStatus); 
    }
}
