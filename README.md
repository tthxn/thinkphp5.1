
###admin目录整合Oauth2.0，原参考网址：https://blog.csdn.net/a1264718192/article/details/84710183

###api目录是整合Oauth2.0编写的restful api，未完成，有待继续开发

###api2目录是整合jwt编写的api接口
基本完成，访问路由 ：http://XXXXX/api2/login可以看到一个demo，提交表单后认证正确会返回相应客户信息
api2/token是封装好的 jwt 获取token接口，或者刷新token,都返回有过期时间
例子：
~~~
{
    "code": 0,
    "msg": "success",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cudGVzdC5uZXQiLCJhdWQiOiJodHRwOlwvXC93d3cudGVzdC5uZXQiLCJpYXQiOjE1NTE2MjY1MjAsIm5iZiI6MTU1MTYyNjUyMCwiZXhwIjoxNTUxNjMzNzIwLCJkYXRhIjp7InVzZXJpZCI6MSwidXNlcm5hbWUiOiInXHU5NzU5XHU5NzU5JyJ9fQ.Z_qdAMnALdk9vfH9YAhj3_m5i-RcsHUpX1WdKcjSzG0",
        "expire": 1551633720,
        "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cudGVzdC5uZXQiLCJhdWQiOiJodHRwOlwvXC93d3cudGVzdC5uZXQiLCJpYXQiOjE1NTE2MjY1MjAsIm5iZiI6MTU1MTYyNjUyMCwiZXhwIjoxNTUyOTIyNTIwLCJkYXRhIjp7InVzZXJpZCI6MSwidXNlcm5hbWUiOiInXHU5NzU5XHU5NzU5JyJ9fQ.kRYpV3x6ZRZiuEIZMupIwygpqwaydbf7I9wDCWObSMQ",
        "refresh_expire": 1552922520
    }
}
~~~