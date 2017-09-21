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
<div class="login">
    <p class="outBox clearfix"><a href="{{route('web.home')}}" class="pull-left">返回首页</a><a href="{{route('web.register')}}" class="pull-right">注册</a></p>
    <div class="login-box">
        <form action="{{route('web.post.login')}}" method="post">
            <p  class="inBox"><a href="{{route('web.home')}}"  class="pull-left">返回首页</a><a href="{{route('web.register')}}" class="pull-right">注册</a></p>
            <p class="logo"><a href="javascript:void(0)">Cool</a></p>
            <p class="username"><input type="text" name="email" placeholder="账号" class="form-control"></p>
            <p class="password"><input type="text" name="password" placeholder="密码" class="form-control"></p>
            {!! csrf_field() !!}
            <p class="submit"><button class="btn btn-warning btn-block btn-lg">登录</button></p>
        </form>
        <p class="forgetPassword text-right"><a href="{{route('web.password.forget.form')}}">忘记密码</a>|<a href="{{route('web.register')}}">注册账号</a></p>
    </div>
</div>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/flexible.js"></script>
<script type="text/javascript">
    $(function(){
        $(".password input").on("focus",function(){
            $(this).attr("type","password");
        });
        $(".password input").on("blur",function(){
            if($(this).val()==""){
                $(this).attr("type","text");
            }
        });
    })
</script>
</body>
</html>
