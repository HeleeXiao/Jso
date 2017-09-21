@extends('web.base')

@section('style')
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/common.css">
@stop

@section('nav')
    <header>
        <nav class="row">
            <div class="container">
                <div class="text-left col-xs-2 col-sm-1 logo"><a href="javascript:void(0)">Cool</a></div>
                <div class="col-xs-8 col-sm-8 inputContent">
                    <div class="input-group">
                        <span class="glyphicon glyphicon-search minico"></span>
                        <input type="text" class="form-control" id="exampleInputAmount" placeholder="输入关键字搜索">
                        <div class="input-group-addon">搜索</div>
                    </div>
                    <!--<span class="glyphicon glyphicon-search minico"></span>-->
                    <!--<input type="text" placeholder="输入关键字搜索" class="form-control pull-left">-->
                    <!--<button type="submit" class="btn btn-warning search pull-left">搜索</button>-->
                </div>
                <div class="col-xs-2 col-sm-2 publish">
                    <a href="javascript:void(0)" class="btn">免费发布消息</a>
                </div>
                <div class="col-xs-2 col-sm-1 text-center user">
                    <a href="javascript:void(0)" id="publish">发布</a>
                    <span class="line"> | </span>
                    <a href="javascript:void(0)" class="glyphicon glyphicon-user"></a>
                </div>
            </div>
        </nav>
        <section class="container">
            <div class="row">
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">销售</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">普工</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">导购员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">保洁</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">发型师</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">司机</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">快递员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">理货员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">保姆</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">营业员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">收银员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">美容师</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">营业员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">文员</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">美容师</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">汽车修理</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">厨师</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">翻译</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">通信</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">物流</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">医药</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">建筑</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">杂工</a>
                <a href="javascript:void(0)" class="col-xs-3 col-sm-1 text-center">其他</a>
            </div>
        </section>
    </header>
@stop

@section('content')
    <div class="content">
        <h4 class="text-center container">最新招聘</h4>
        <ul class="container content-list">
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
            <li class="clearfix">
                <div class="col-xs-9 col-sm-5">
                    <p class="name">资深php开发</p>
                    <p class="salary"><span>12000-20000</span>元/月</p>
                    <p class="job_wel"><span>五险一金</span><span>包吃</span><span>周末双休</span><span>年底双薪</span></p>
                </div>
                <div class="col-xs-5 col-sm-4 comp">
                    <p class="comp_name">上海旭胜金融信息服务股份有限公司</p>
                    <p class="job_require"><span>软件工程师</span>|<span>本科</span>|<span>3-5年</span></p>
                </div>
                <div class="apply col-xs-3 col-sm-3">
                    <a href="javascript:void(0)" class="btn">申请</a>
                </div>
                <p class="company col-xs-12">上海旭胜金融信息服务股份有限公司 <span class="pull-right">五角场</span></p>
            </li>
        </ul>
    </div>
@stop

@section('footer')
    @include('web.default.footer')
@stop