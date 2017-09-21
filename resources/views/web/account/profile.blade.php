@extends('web.base')
@section('style')
    <style>
        .list-group .list-group-item.active{background-color: #fde538;}
        .list-group .list-group-item.active:hover, .list-group .list-group-item.active:focus{background-color: #fde538;}
        .list-group li h4 a{color: #333;}
        .profile{font-size: 16px;} .profile dt, .profile dd{padding: 5px;}
    </style>
@stop

@section('content')
    <div class="container" style="padding-top: 80px; padding-bottom: 100px;">
        <div class="row">
            @include('web.account.sidebar')
            <div class="col-md-9">
                <h4>Profile</h4>
                <hr />
                <div class='profile text-left'>
                    <dl class="dl-horizontal">
                        <dt>用户名：</dt>
                        <dd>
                            <span>{{$user->nickname}}</span>
                        </dd>
                        <dt>手&nbsp;&nbsp;&nbsp;&nbsp;机：</dt>
                        <dd>
                            <span>{{$user->mobile}}</span>
                        </dd>
                        <dt>邮&nbsp;&nbsp;&nbsp;&nbsp;箱：</dt>
                        <dd>
                            <span>{{$user->email}}</span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('web.default.footer')
@stop