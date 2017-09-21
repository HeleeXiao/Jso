@extends('web.base')
@section('style')
    <style>
        .list-group .list-group-item.active{background-color: #fde538;}
        .list-group .list-group-item.active:hover, .list-group .list-group-item.active:focus{background-color: #fde538;}
        .list-group li h4 a{color: #333;}
    </style>
@stop

@section('content')
    <div class="container" style="padding-top: 80px; padding-bottom: 100px;">
        <div class="row">
            @include('web.account.sidebar')
            <div class="col-md-4 col-md-offset-1">
                <p class="lead">修改密码</p>
                <form action="{{route('web.password.post.modify')}}" method="post" style="font-size: 14px;">
                    <div class="form-group">
                        <label for="old_password">旧密码</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="请输入旧密码">
                    </div>
                    <div class="form-group">
                        <label for="password">新密码</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="6-16个字符">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">新密码</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="6-16个字符">
                    </div>
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('web.default.footer')
@stop