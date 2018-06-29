<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Validator;
use Gate;
use App\Model\Users;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ResetPasswordRequest;

class UserController extends BaseController
{
	public function __construct(Users $users)
	{
		$this->users = $users;
	}
    public function index()
    {  
        $page = array_get($_GET,'page',1);
        $limit = array_get($_GET,'limit',10);
        $offset = ($page-1) * $limit; 
        $count = DB::table('users')->count();
        $data = DB::table('users')->offset($offset)->limit($limit)->get();
    	return view('admin.user.index')->with(['data'=>$data]);
    }

    public function getUserlist(){
    	$page = array_get($_GET,'page',1);
    	$limit = array_get($_GET,'limit',10);
    	$offset = ($page-1) * $limit; 
    	$count = DB::table('users')->count();
    	$data = DB::table('users')->offset($offset)->limit($limit)->get();
    	return $this->getlistData($data,$count);	
    }

    public function edit($id)
    {	
    	
    	if (Gate::denies('update users', $id)) {
	   		//权限
		}
    	$data = $this->users->getRowById($id); 
    	
    	return view('admin.user.edit')->with('data',$data);
    }

    public function create()
    {
    	return view('admin.user.create');
    }
    public function store(UserRequest $request)
    {   
    	/*$validatedData = $request->validate([
    		'name' => 'bail|required|unique:users',
    		'email' => 'bail|required|unique:users',
    		'password' => 'required|string|min:6|confirmed',
    	]);*/
    	
	  //  $validator = Validator::make($request->all(), $rules, $messages);
		$result =  DB::table('users')->insert([
            'name' =>$request->input('name'),
            'email' => $request->input('email'),
            'status' => $request->input('status'),
            'password' => Hash::make($request->input('password')),
	    ]);
	    if($result == true){
	    	return $this->arrayAjax('','添加成功',0);
	    }else{
	    	return $this->arrayAjax('','添加失败',-1);
	    }
    }

    public function update(Request $request)
    { 
    	$validatedData = $request->validate([
    		'email' => 'bail|required',
    	]); 
		$result =  DB::table('users')->where('id',$request->input('id'))->update([
	            'email' => $request->input('email'),
	            'status' => $request->input('status'),
	    ]);

	    if($result == true){
	    	return $this->arrayAjax('','修改成功',0);
	    }else{
	    	return $this->arrayAjax('','修改失败',-1);
	    }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
    	
	  //  $validator = Validator::make($request->all(), $rules, $messages);
	  
    	$result =  DB::table('users')->where('id',$request->input('id'))->update([
	            'password' => Hash::make($request->input('password')),
	    ]);
    	 if($result == true){
	    	return $this->arrayAjax('','修改成功',0);
	    }else{
	    	return $this->arrayAjax('','修改失败',-1);
	    }
    }

}
