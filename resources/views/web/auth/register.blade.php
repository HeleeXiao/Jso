<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
    <div class="login register">
        <p class="outBox clearfix"><a href="{{route('web.home')}}" class="pull-left">返回首页</a><a href="{{route('web.login')}}" class="pull-right">已有账号去登录</a></p>
        <div class="login-box">
            <form action="{{route('web.post.register')}}" method="post">
                <p  class="inBox"><a href="{{route('web.home')}}"  class="pull-left">返回首页</a><a href="{{route('web.login')}}" class="pull-right">已有账号去登录</a></p>
                <p class="logo"><a href="javascript:void(0)">Cool</a></p>
                <p class="email"><input type="text" name="email" value="{{old('email')}}" placeholder="邮件地址" class="form-control"></p>
                <p class="username"><input type="text" name="username" value="{{old('username')}}" placeholder="用户名" class="form-control"></p>
                <p class="password"><input type="text" name="password" placeholder="密码" class="form-control"></p>
                <p class="rePassword"><input type="text" name="password_confirmation" placeholder="确认密码" class="form-control"></p>
                {!! csrf_field() !!}
                <p class="agreement">
                    <label>
                        <input type="checkbox" value="1" name="protocol" checked>
                        <span>本人已仔细阅读并同意《coo工作用户服务协议》和《cool工作公约》所有条款和条件</span>
                    </label>
                </p>
                <p class="submit"><button class="btn btn-warning btn-block btn-lg">登录</button></p>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/flexible.js"></script>
    <script type="text/javascript">
        $(function(){
            function password(eles){
                $(eles).on("focus",function(){
                    $(this).attr("type","password");
                });
                $(eles).on("blur",function(){
                    if($(this).val()==""){
                        $(this).attr("type","text");
                    }
                });
            }
            password(".password input");
            password(".rePassword input");

        })
    </script>
</body>
</html>
