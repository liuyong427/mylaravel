<?php
/**JWT
 * 
 */
namespace App\Http\Controllers\Webapp;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTFactory;
use Illuminate\Http\Request;

class AuthenticateController extends Controller{
	public function login(Request $request)
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

    public function test()
    {
    	//用户登陆获取token
    	$user = User::first();print_R($user->toarray());
		$token = JWTAuth::fromUser($user);print_R($token);

		//传递参数
		$customClaims = ['foo' => 'bar', 'baz' => 'bob'];
		$payload = JWTFactory::make($customClaims); print_R($payload);
		$token1 = JWTAuth::encode($payload);
		print_R($token1);

		//
		$payload = JWTFactory::sub(123)->aud('foo')->foo(['bar' => 'baz'])->make();
		$token2 = JWTAuth::encode($payload);
		print_R($token2);	
    }

  	public function getUser()
	{ 
	    try {
	        if (! $user = JWTAuth::parseToken()->authenticate()) {
	            return response()->json(['user_not_found'], 404);
	        }
	    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
	        return response()->json(['token_expired'], $e->getStatusCode());
	    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
	        return response()->json(['token_invalid'], $e->getStatusCode());
	    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
	        return response()->json(['token_absent'], $e->getStatusCode());
	    }

	    // the token is valid and we have found the user via the sub claim

	    return response()->json(['user'=>$user]);
	}
}