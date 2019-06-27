<?php
// use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 
	//api版本号可以在请求头、参数、URL路由参数中传入，三者只能选一种使用
	//:version--版本; :controller--控制器占位符; :function--方法占位符; :id参数占位符，对应方法形参只能用$id接受
	//
	//1.请求参数传入方式
	// \think\Route::rule(':version/:controller/:function/:id','api/:version.:controller/:function');   //或者在上面use think\Route;

	//2.请求头传入方式
	// $v = request()->header('version');
	// if($v==null) $v = "v1";   //默认版本号是v1

return [
	//路由
	'news'=>'index/stu/index',   //定义路由，前提是在config.php开启路由'url_route_on'=> true;定义之后，本页面的传统访问方式将变为非法的
	'shi/:name'=>'index/stu/shi',   //定义带参数的路由,:name为参数占位符，对应控制器方法只能用$name接收

	//2.请求头传入方式(不指定版本号)
    // 'api/:controller/:id$'=>['api/'.$v.'.:controller/read',['method' => 'get']],
    // 'api/:controller/:function/:id$'=>'api/'.$v.'.:controller/:function',
	
	//3.api版本URL路由传入方式（推荐）
 	// 'api/:version/:controller/:id'=>'api/:version.:controller/read',// 省略方法名时,二者只可以使用一种
    'api/:version/:controller/:function/:id'=>'api/:version.:controller/:function',// 有方法名时

    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
