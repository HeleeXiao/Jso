@extends('web.base')

@section('content')
    <div class="container" style="padding-bottom: 100px; padding-top: 80px; font-size: 14px;min-height: 500px;">
        <div class="row" style="padding-top: 120px;">
            <div class="col-md-12 text-center">
                @if($expired_at)
                    <h3>该链接已失效，请重新找回密码</h3>
                    <p>即将为您自动跳到找回密码界面！(<span id="countdown">3</span>s)</p>
                @else
                    <p>当前账户名：{{$user->nickname}}</p>
                    <p>已向 {{$user->email}} 发送验证邮件， 请点击邮件中的链接重设您的登录密码</p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('web.default.footer')
@stop

@section('script')
    <script>
        $(function () {
            @if($expired_at)
            //倒计时脚本 @陈众

            @endif
        });
    </script>
@stop