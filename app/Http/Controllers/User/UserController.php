<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function login(Request $request)
    {
    	try{
    		$request->validate([
    			'email'=>'required|email',
    			'password'=>'required'
    		]);
    		$user=User::where('email',$request->email)->first();
    		if(!$user || !Hash::check($request->password,$user->password)){
    			return response()->json([
    				'message'=>'Invalid email or password'],401);
    		}
    		$token=$user->createToken('my-app')->plainTextToken;
    		return response()->json([
    			'user'=>$user,
    			'token'=>$token],200);
    	}
    	catch(Exception $error){
    		return response()->json([
    			'error'=>$error,
    			],400);
    	}
	}
	public function register(Request $request){

    	try{
    		$request->validate([
    			'name'=>'required|min:3',
    			'email'=>'required|email|unique:users',
    			'password'=>'required'
    		]);
    		$user=User::create([
    			'name'=>$request->name,
    			'email'=>$request->email,
    			'password'=>$request->password]);
    		$token=$user->createToken('my-app')->plainTextToken;
    		return response()->json([
    			'user'=>$user,
    			'message'=>'Registration Completed',
    			'token'=>$token],201);
    	}
    	catch(Exception $error){
    		return response()->json([
    			'error'=>$error,
    			],400);
    	}


	}
	public function logout(Request $request){
		auth()->user()->tokens()->delete();
		return response()->json([		
    			'message'=>'Logout successfully'
    			],200);
	}
}
