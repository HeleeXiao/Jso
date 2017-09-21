@extends('web.base')

@section('content')
    @if($expired_at)
    <div class="container">
        <div class="col-md-6 text-center">
            <h3>该链接已失效，请重新找回密码</h3>
            <p>即将为您自动跳到找回密码界面！(<span id="countdown">3</span>s)</p>
        </div>
    </div>
    @else
    <div class="container" style="padding-bottom: 100px; padding-top: 80px; font-size: 14px;min-height: 500px;">
        <div class="row"  style="padding-top: 60px;">
            <div class="col-md-6 col-md-offset-3">
                <p>已经成功验证，请立即修改您的密码!</p>
                <form class="form" action="{{route('web.password.post.reset')}}" method="post">
                    <div class="form-group">
                        <label for="password"></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="新密码">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation"></label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="确认新密码">
                    </div>
                    <div class="form-group">
                        {!! csrf_field() !!}
                        <input type="hidden" name="reset_token" value="{{$resetToken}}" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
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