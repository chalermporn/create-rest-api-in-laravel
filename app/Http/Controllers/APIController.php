<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use Validator;

class APIController extends Controller
{
    function sendResponse($result,$message){
		$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

		return response()->json($response, 200);
	}
	public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
    public function getAllPosts()
    {
        $posts = Post::all();
        return  $this->sendResponse($posts->toArray(), 'Posts retrieved successfully.');
    }
    public function createPost(Request $request)
    {
		$validator = Validator::make($request->all(),[
	      'name'=>'required',
	      'description' =>'required',
        ]);

        if($validator->fails()) {
            return $this->sendError(0,$validator->errors()->all());
        }
    		$name=$request->name;
    		$description=$request->description;
        $posts = Post::create(['name'=>$name,'description'=>$description]);
        return  $this->sendResponse(1, 'Post successfully created.');
    }
}
