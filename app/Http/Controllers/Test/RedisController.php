<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index()
    {
    	Redis::set('name', 'liuuter');
    	$name = Redis::get('name');
    	print_R($name);
    }
}
