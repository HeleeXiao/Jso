@extends('web.base')
@section('style')
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/offers.css">
@endsection
@section('content')
<div class="flow">
    <ul class="container">
        <li class="col-xs-4"><span>1 招聘全职</span>（<a href="javascript:void (0)">重选类别</a>）</li>
        <li class="col-xs-4"><span>2 填写信息</span></li>
        <li class="col-xs-4"><span>3 发布成功</span></li>
    </ul>
</div>
<form class="companyInf" action="{{action('Web\AdController@store')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="container infoWrap">
        <dl class="clearfix row">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <span class="title">公司名称</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <span>小春信於（上海）网络科技有限公司</span>
                <span class="com-nameTips">如需修改，请<a href="javascript:void (0)">上传营业执照</a></span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <span class="title">标题</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" placeholder="标题" class="com-nickname mushInput" name="title" id="title">
                <span class="wrong-tip">
                <i class="glyphicon glyphicon-remove"></i>
                <span class="natureValue">请填写标题</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <span class="title">公司别称</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" placeholder="公司的口语称呼，没有时填写全称" class="com-nickname mushInput" name="com_name" id="com_name">
                <span class="wrong-tip">
                <i class="glyphicon glyphicon-remove"></i>
                <span class="natureValue">请填写企业别称</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <span class="title">所属行业</span>
            </dt>
            <dd class="col-xs-9 col-sm-10 belongs-industry">
                <select name="com_industry" id="com_industry"  class="pull-left mushInput">
                    <option value="">请选择所属行业</option>
                    <option value="金融">金融</option>
                    <option value="教育">教育</option>
                    <option value="旅游/酒店">旅游/酒店</option>
                    <option value="互联网/计算机">互联网/计算机</option>
                    <option value="互联网/计算机">互联网/计算机</option>
                    <option value="房地产">房地产</option>
                    <option value="广告">广告</option>
                    <option value="家居设计">家居设计</option>
                    <option value="其他">其他</option>
                </select>
                <span class="pull-left wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请选择公司性质</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <span class="title">工作分类</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <select id="job_type" name="job_type" ></select>
                <script>
                    num = select_type.length
                    str = '';
                    for(i = 1 ; i < num ; i++){
                        document.getElementById('job_type').options.add(new Option(select_type[i],i));
                    }
                </script>
                <span class="wrong-tip">
                <i class="glyphicon glyphicon-remove"></i>
                <span class="natureValue">请选择工作分类</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <span class="title">公司性质</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <select name="com_type" id="com_type" class="pull-left">
                    <option value="">请选择公司性质</option>
                    <option value="私营">私营</option>
                    <option value="国有">国有</option>
                    <option value="股份制">股份制</option>
                    <option value="外商独资/办事处">外商独资/办事处</option>
                    <option value="中外合资/合作">中外合资/合作</option>
                    <option value="上市公司">上市公司</option>
                    <option value="事业单位">事业单位</option>
                    <option value="政府机关">政府机关</option>
                    <option value="非营利机构">非营利机构</option>
                    <option value="个人企业">个人企业</option>
                </select>
                <span class="wrong-tip">
                <i class="glyphicon glyphicon-remove"></i>
                <span class="natureValue">请选择公司性质</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b  class="must-symbol">＊</b>
                <span class="title">公司规模</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <select name="com_persons" id="com_persons" class="pull-left mushInput">
                    <option value="">请选择公司规模</option>
                    <option value="1-49人">1-49人</option>
                    <option value="50-99人">50-99人</option>
                    <option value="100-499人">100-499人</option>
                    <option value="500-999人">500-999人</option>
                    <option value="1000人以上">1000人以上</option>
                </select>
                <span class="pull-left wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请选择公司规模</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b  class="must-symbol">＊</b>
                <label for="com-synop">
                    <span class="title">公司简介</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
            <textarea id="com_profile" name="com_profile" class="mushInput"
                      placeholder="请简单介绍您的公司信息，让求职者了解您的公司，如：公司的主要业务，经营范围，公司规模，公司性质，成立时间等。"></textarea>
                <span class=" wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请填写公司简介</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <label for="com-linkman">
                    <span class="title">招聘人数</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" name="num" id="num" class="com-linkman mushInput">
                <span class=" wrong-tip" >
                <i class=""></i>
                <span class="natureValue">招聘人数</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <label for="com-linkman">
                    <span class="title">联&nbsp;&nbsp;系&nbsp;&nbsp;人</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" name="contacts" id="contacts" class="com-linkman mushInput">
                <span class=" wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请填写联系人</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <label for="com-phone1">
                    <span class="title">招聘电话</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <div class="phone1">
                    <input type="text" name="tel1" id="tel1" class="com-phomeNum mushInput">
                    <span class="addPhoneBtn ml_15 fl">添加</span>
                    <label class="public"><input name="tel_secrecy" type="checkbox" value="1"/>不公开</label>
                    <span class=" wrong-tip" >
                    <i class=""></i>
                    <span class="natureValue">请填写招聘电话</span>
                </span>
                </div>
                <div class="phone2 clearfix" style="display: none">
                    <input type="text" id="tel2" name="tel2" class="com-phomeNum text-default fl">
                    <span class="removePhoneBtn fl">删除</span>
                    <span class="compho-tip2 ml_15 fl"></span>
                </div>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <label for="com-mail">
                    <span class="title">招聘邮箱</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" name="email" id="email" class="com-mail">
                <span class=" wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请输入联系邮箱</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <label for="com-web">
                    <span class="title">公司网址</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" name="com_url" id="com_url" class="com-web text-default fl">
                <span class=" wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请输入您的公司网址</span>
            </span>
            </dd>
        </dl>
        {{--<dl class="clearfix">--}}
            {{--<dt class="col-xs-4 col-sm-2">--}}
                {{--<span class="title">公司福利</span>--}}
            {{--</dt>--}}
            {{--<dd class="col-xs-8 col-sm-10">--}}
                {{--<p class="list-welDefult">--}}
                    {{--<label><input type="checkbox" value="五险一金">五险一金</label>--}}
                    {{--<label><input type="checkbox" value="包吃">包吃</label>--}}
                    {{--<label><input type="checkbox" value="包住">包住</label>--}}
                    {{--<label><input type="checkbox" value="周末双休">周末双休</label>--}}
                    {{--<label><input type="checkbox" value="年底双薪">年底双薪</label>--}}
                    {{--<label><input type="checkbox" value="房补">房补</label>--}}
                    {{--<label><input type="checkbox" value="话补">话补</label>--}}
                    {{--<label><input type="checkbox" value="交补">交补</label>--}}
                    {{--<label><input type="checkbox" value="饭补">饭补</label>--}}
                    {{--<label><input type="checkbox" value="加班补助">加班补助</label>--}}
                {{--</p>--}}
            {{--</dd>--}}
        {{--</dl>--}}
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b  class="must-symbol">＊</b>
                <span class="title">公司地址</span>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <select id="area_city_level_id" name="area_city_level_id" class="pull-left">
                    @foreach($area as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                </select>
                <select id="area_first_level_id" name="area_first_level_id" class="pull-left">
                    @foreach($city as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                </select>
                <span class="pull-left wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请选择公司所处区域</span>
            </span>
            </dd>
        </dl>
        <dl class="clearfix">
            <dt class="col-xs-3 col-sm-2">
                <b class="must-symbol">＊</b>
                <label for="addrDetail">
                    <span class="title">详细地址</span>
                </label>
            </dt>
            <dd class="col-xs-9 col-sm-10">
                <input type="text" name="address" id="address" class="addrDetail mushInput" placeholder="请填写公司地址，如中关村南大街180号">
                <span class=" wrong-tip" >
                <i class=""></i>
                <span class="natureValue">请填写详细地址8-50个字</span>
            </span>
            </dd>
        </dl>
        <dl class="com-submit">
            <input type="submit" value="下一步" id="submit" class="btn">
        </dl>
    </div>
</form>


<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/flexible.js"></script>
<script>
    $(function(){

        function checkInput(Input){
            var theInput=$(Input);
            theInput.on("focus",function(){
                $(this).parent().find(".wrong-tip").css("display","inline-block");
                $(this).parent().find(".wrong-tip").css("color","#337ab7");
                $(this).parent().find(".wrong-tip").find("i").attr("class","glyphicon glyphicon-info-sign").css("background","#337ab7");
            });
            theInput.on("blur",function(){
                if($(this).val()=="" && $(this).hasClass("mushInput")){
                    $(this).parent().find(".wrong-tip").css("color","#ff552e");
                    $(this).parent().find(".wrong-tip").find("i").attr("class","glyphicon glyphicon-remove").css("background","#ff552e");
                }else{
                    $(this).parent().find(".wrong-tip").css("display","none");
                }
            });
        }
        checkInput(".infoWrap input");
        checkInput(".infoWrap select");
        checkInput(".infoWrap textarea");
        $(".list-welDefult label").on("click",function(){
            if(!$(this).hasClass("active")){
                $(this).addClass("active");
                return false;
            }else{
                $(this).removeClass("active");
                return false;
            }
        });
        $(".addPhoneBtn").on("click",function(){
            $(".phone2").show();
            $(this).hide();
        });
        $(".removePhoneBtn").on("click",function(){
            $(".phone2").hide();
            $(".addPhoneBtn").show();
        });


    })
</script>
@endsection