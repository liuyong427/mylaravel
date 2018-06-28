<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
	/**
	 * getlistData 列表数据
	 * @param  [type]  $data  [description]
	 * @param  [type]  $count [description]
	 * @param  string  $msg   [description]
	 * @param  integer $code  [description]
	 * @return [type]         [description]
	 */
	public function getlistData($data,$count,$msg='success',$code=0)
	{
		$return = [
			'data' => $data,
			'count' => $count,
			'msg' => $msg,
			'code' => $code,
		];
		return json_encode($return);
	}

	public function jsonAjax($data,$msg,$code)
	{
		return json_encode([
			'data' => $data,
			'msg' => $msg,
			'code' => $code,
		]);
	}

	public function arrayAjax($data,$msg,$code)
	{
		return [
			'data' => $data,
			'msg' => $msg,
			'code' => $code,
		];
	}

}