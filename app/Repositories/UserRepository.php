<?php
namespace App\Repositories;

use App\Model\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
	public function getOneByid($id){
		return User::where('id',$id)->first();
	}

	public function getAll(){
        return User::all();
    }

    public function getCount(){
    	return User::count();
    }

    public function getPageData($arr){
    	$page =$arr['page']?$arr['page']:1;
    	$limit = $arr['limit']?$arr['limit']:10;
    	$offset = ($page-1) * $limit; 
    	return $data =User::offset($offset)->limit($limit)->get();
    }

    public function insert($arr){
    	$result =  User::insert([
            'name' => $arr['name'],
            'email' =>  $arr['email'],
            'status' =>  $arr['status'],
            'password' => Hash::make( $arr['password']),
	    ]);
	    return $result;
    }

    public function updateUser($arr,$id){ 
		$result =  User::where('id',$id)->update([
	            'email' =>$arr['email'],
	            'status' => $arr['status'],
	    ]);
	    return $result;
    }

    public function resetPassword($password,$id){
    	return User::where('id',$id)->update([
	            'password' => Hash::make($password),
	    ]);
    }
}