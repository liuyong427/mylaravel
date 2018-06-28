<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	$a = 'code';
    	echo trim('ecdo 1',$a);
    }


	public function test(Request $request,$method='')
    {  
    	switch($method){
    		case 'test':
    			return 'this is a test';
    			break;
    		case 'phpCode':
    			return $this->strToPhp($request);
    		case 'path':
    			return $request->path();
    			break;
    		default:
    			return 'please pass a right method name';
    	}
    }

    protected function strToPhp($request)
    {	
    	$phpCode = $request->input('phpCode');	
    	if($phpCode =='' ){
    		return 'please write your php code first';
    	} 
    	if(substr($phpCode,0,4) == 'code'){
    			$phpCode = substr($phpCode,4);
    	}
    	
    	$data = eval($phpCode);
    	return $data;
    }

 
}