<?php

namespace App\Http\Controllers\Webapp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Foundation\Auth\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTFactory;

class LoginController extends Controller
{
    public function index()
    {
    	return view('webapp/index');
    }

   	public function loginIn(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}
