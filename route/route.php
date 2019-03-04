<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

/*******************************restfunl api************************************* */
//一般路由规则，访问的url为：v1/address/1,对应的文件为Address类下的read方法
Route::get(':version/address/:id','api/:version.user/address');

//资源路由，详情查看tp手册资源路由一章
Route::resource(':version/user','api/:version.user');

//生成access_token，post访问Token类下的token方法
Route::post(':version/token','api/:version.token/token');
/////////////////////////////////////////////////////////////////////////////////
Route::get(':version/register', 'api/:version.register/register');//用户注册

/****************************admin1中整合Oauth2.0*********************************/
Route::get('oauth/authorize', 'admin1/OAuth/authorize');
Route::post('oauth/authorize', 'admin1/OAuth/authorize');

Route::get('token', 'admin1/OAuth/token');
Route::post('token', 'admin1/OAuth/token');

Route::get('resource', 'admin1/OAuth/resource');
Route::post('resource', 'admin1/OAuth/resource');

//后台用户管理
Route::group('admin1', function () {
    Route::get('doRegister', 'admin1/login/doRegister');//用户注册

    Route::get('login', 'admin1/login/index');
    Route::get('doLogin', 'admin1/login/doLogin');
});


/*******************************jwt中token接口生成***************************************/
Route::get('api2/token', 'api2/token/index');//获取token
//api接口管理，当前方法使用的是jwt加密方式
Route::get('api2/login', 'api2/login/index');//登陆
Route::post('api2/doLogin', 'api2/login/doLogin');//ajax提交表单,登陆状态
//以下内容需要走中间件进行token验证
Route::group('api2', function () {
    Route::get('getInfo', 'api2/login/getInfo');//获取用户相关信息：id。username.picture
})->middleware(['JWTAuth']);

/*************************************后台网站管理************************************/
Route::group('admin', function () {
    Route::get('login/login', 'admin/login/index');
    Route::post('login/doLogin', 'admin/login/doLogin');
});

