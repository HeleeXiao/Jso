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
            <div class="col-md-9">

            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('web.default.footer')
@stop