<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/forgetPassword.css" />
</head>
<body class="register1">
    <header>
        <div class="container clearfix">
            <div class="pull-left">
                <a href="javascript:void(0)" class="logo pull-left">Cool</a>
                <div class="pull-left titleFa"><span class="title">找回密码</span></div>
            </div>
            <div class="pull-right loginOrReg">
                <a href="{{route('web.login')}}">登录</a>|<a href="{{route('web.register')}}">注册</a>
            </div>
        </div>
    </header>
    <div></div>
    <div class="content">
        <div class="container">
            <h2 class="tit clearfix">
            <span class="one step active">
                <b>1</b>
                <i>确认账户</i>
            </span>
                <em class="line"></em>
                <span class="two step">
                <b>2</b>
                <i>验证账户</i>
            </span>
                <em class="line"></em>
                <span class="three step">
                <b>3</b>
                <i>重置密码</i>
            </span>
            </h2>
            <form action="{{route('web.password.post.send.mail')}}" method="post">
                <p class="name">
                    <input type="text" name="email" placeholder="手机号/邮箱/用户名">
                </p>
                <p class="VerifCode">
                    <input type="text" name="captcha" placeholder="图片验证码" maxlength="5" />
                    <img id="captcha" src="{!! captcha_src() !!}" alt="点击更换验证码">
                </p>
                <p id="mobilep">
                    {!! csrf_field() !!}
                    <input type="submit" value="提交" class="submit" id="btnSubmit">
                </p>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/flexible.js"></script>
    <script>
        $(function () {
            $('#captcha').click(function() {
                $.get('{{route("web.captcha")}}', function (captcha_src) {
                    $('#captcha').attr('src', captcha_src);
                });
            });
        });
    </script>
</body>
</html>
