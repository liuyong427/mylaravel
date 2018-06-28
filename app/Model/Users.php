<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	protected $table = 'users';
	

   	public function getRowById($id)
   	{
   		return $this->where('id',$id)->first();
   	}
}
