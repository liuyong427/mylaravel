<?php
namespace App\Repositories;

use App\Model\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
	private $where;
	public function getOneByid($id){
		return User::where('id',$id)->first();
	}

	public function getAll(){
        return User::all();
    }

    public function getCount($arr){
    	$where = $this->searchWhere($arr);
    	return User::where($where)->count();
    }

    public function getPageData($arr){
    	$page =$arr['page']?$arr['page']:1;
    	$limit = $arr['limit']?$arr['limit']:10;
    	$offset = ($page-1) * $limit; 
    	$where = $this->searchWhere($arr);
    	return $data =User::where($where)->offset($offset)->limit($limit)->get();
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

    public function destroyUser($id){
    	return User::where('id', $id)->delete();
    }

    public function resetPassword($password,$id){
    	return User::where('id',$id)->update([
	            'password' => Hash::make($password),
	    ]);
    }

    public function searchWhere($arr){
    	$condition =[]; 
    	if(isset($arr['key'])){
    		foreach($arr['key'] as $k => $v){
    			if($v){
    				switch($k){
    					case 'status':
	    					$condition[] = [$k,$v];
	    					break;
    					default:
    						$condition[] = [$k,'like',"%$v%"];
    				}
    			}
    		}
    	}
    
    	return $condition;
    }
}