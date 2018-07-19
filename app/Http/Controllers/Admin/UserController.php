<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Validator;
use Gate;
use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ResetPasswordRequest;

use App\Events\OrderShipped;

class UserController extends BaseController
{
	public function __construct(UserRepository $users)
	{
		$this->users = $users;
	}
    public function index()
    {  
    	return view('admin.user.index');
    }

    public function getUserlist(Request $request){
    	$count = $this->users->getCount($request->all()); 
    	$data = $this->users->getPageData($request->all());
    	return $this->getlistData($data,$count);	
    }

    public function edit($id)
    {	
    	
    	if (Gate::denies('update users', $id)) {
	   		//权限
		}
    	$data = $this->users->getOneByid($id); 
    	return view('admin.user.edit')->with('data',$data);
    }

    public function create()
    {
    	return view('admin.user.create');
    }
    public function store(UserRequest $request)
    {   
		$result = $this->users->insert($request->all());
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
        $result = $this->users->updateUser($request->all(),$request->input('id'));
	    if($result == true){
	    	return $this->arrayAjax('','修改成功',0);
	    }else{
	    	return $this->arrayAjax('','修改失败',-1);
	    }
    }

    public function show($id){
        $data = $this->users->getOneByid($id);
        return view('admin.user.show')->with('data',$data);
    }

    public function destroy($id){
        $result = $this->users->destroyUser($id);
         if($result == true){
            return $this->arrayAjax('','删除成功',0);
        }else{
            return $this->arrayAjax('','删除失败',-1);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
    	
	  //  $validator = Validator::make($request->all(), $rules, $messages);
	  
    	$result = $this->users->resetPassword($request->input('password'),$request->input('id'));
    	 if($result == true){
	    	return $this->arrayAjax('','修改成功',0);
	    }else{
	    	return $this->arrayAjax('','修改失败',-1);
	    }
    }

    public function setEvent()
    {
        $user = $this->users->getOneByid(1)->toarray();
        print_R($user);
        event(new OrderShipped($this->users));
    }

}
