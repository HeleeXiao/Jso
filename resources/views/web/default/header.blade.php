<div id="commonTopbar">
    <div class="container clearfix">
        <div class="pull-left">上海</div>
        <div class="pull-right row">
            @if(\App\Models\Visitor::user())
                <div class="col-xs-2 col-md-2">
                    <a href="javascript:void(0)">{{\App\Models\Visitor::user()->email}}</a>
                    <span>/</span>
                    <a href="{{route('web.logout')}}">退出</a>
                </div>
            @else
                <div class="col-xs-2 col-md-2">
                    <a href="{{route('web.login')}}">登录</a>
                    <span>/</span>
                    <a href="{{route('web.register')}}">注册</a>
                </div>
            @endif
            <div class="col-xs-2 col-md-2">
                <a href="{{route('web.account.profile')}}">个人中心</a>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="col-xs-2 col-md-2">
                <a href="javascript:void(0)">商家中心</a>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="col-xs-2 col-md-2">
                <a href="javascript:void(0)">帮助中心</a>
            </div>
            <div class="col-xs-2 col-md-2">
                <a href="javascript:void(0)">最近浏览</a>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </div>
            <div class="col-xs-2 col-md-2">
                <a href="javascript:void(0)">网站导航</a>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </div>
        </div>
    </div>
</div>
<nav class="row commonNav">
    <div class="container">
        <div class="text-left col-xs-2 col-sm-1 logo"><a href="{{url('/')}}">Cool</a></div>
        <div class="col-xs-7 col-sm-8 inputContent">
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
            <a href="{{url('/ad/create')}}" class="btn">免费发布消息</a>
        </div>
        <div class="col-xs-3 col-sm-1 text-center user">
            <a href="javascript:void(0)" id="publish">发布</a>
            <span class="line"> | </span>
            <a href="javascript:void(0)" class="glyphicon glyphicon-user"></a>
        </div>
    </div>
</nav>
{{--logo、导航、等非页面主体内容（GLQ维护，在不了解以下标签具体含义及真实页面布局前提下先使用此标签制作演示页面）--}}
<?php
//这个数组仅限当前阶段演示使用，上线肯定要换方案，望各位大牛明鉴
$select_type = array(
    '1' => '销售', '2' => '普工', '3' => '导购员', '4' => '保洁', '5' => '发型师', '6' => '司机', '7' => '快递员', '8' => '理货员',
    '9' => '保姆', '10' => '营业员', '11' => '收银员', '12' => '美容师', '13' => '文员', '14' => '美容师', '15' => '汽车修理',
    '16' => '厨师', '17' => '翻译', '18' => '通信', '19' => '物流', '20' => '医药', '21' => '建筑', '22' => '杂工', '23' => '其他'
)
?>
<script>
    var select_type=new Array()
    select_type[1]="销售";
    select_type[2]="普工";
    select_type[3]="导购员";
    select_type[4]="保洁";
    select_type[5]="发型师";
    select_type[6]="司机";
    select_type[7]="快递员";
    select_type[8]="理货员";
    select_type[9]="保姆";
    select_type[10]="营业员";
    select_type[11]="收银员";
    select_type[12]="美容师";
    select_type[13]="文员";
    select_type[14]="美容师";
    select_type[15]="汽车修理";
    select_type[16]="厨师";
    select_type[17]="翻译";
    select_type[18]="通信";
    select_type[19]="物流";
    select_type[20]="医药";
    select_type[21]="建筑";
    select_type[22]="杂工";
    select_type[23]="其他";
</script>
@yield('nav')
@yield('sidebar')