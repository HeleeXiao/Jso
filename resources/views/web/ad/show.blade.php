@extends('web.base')
@section('style')
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/offers.css">
    <link rel="stylesheet" href="/css/detail.css">
@endsection
@section('content')
<div class="content">
    <div class="container clearfix">
        <div class="bread">
            <span>
                <a href="javascript:void(0)">{{$data->com_name}}</a>
                <span>&nbsp;&gt;&nbsp;</span>
                <a href="javascript:void(0)">{{$data->title}}</a>
            </span>
        </div>
        <div class="information clearfix">
            <div class="pull-left jobDetail">
                <div class="statistics">
                    <span class="update"> 更新:  <span>今天</span>  </span>
                    <span class="browser">浏览:<i id="totalCount">1652</i>人</span>
                    <span class="apply">申请:<span id="applyNum">24</span>人</span>
                    <div class="pull-right clearfix">
                        <a href="javascript:void(0)" class="collection">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="txt">收藏</i>
                        </a>
                        <span class="share">
                            <i class="glyphicon glyphicon-share"></i>
                            <a href="javascript:void(0)">分享</a>
                        </span>
                        <div class="pull-right report">
                            <i class="glyphicon glyphicon-alert"></i>
                            <i>举报</i>
                        </div>
                    </div>
                </div>
                <div class="detailTitle clearfix">
                    <h2 class="pull-left">{{$data->title}}</h2>
                    <h2 class="pull-right salary">薪资面议</h2>
                </div>
                <p class="jobName">{{$data->job_name}}</p>
                <p class="job_wel">
                    <span>五险一金</span>
                    <span>包吃</span>
                    <span>周末双休</span>
                    <span>年底双薪</span>
                    <span>饭补</span>
                    <span>加班补助</span>
                    <span>生活便利</span>
                </p>
                <div class="jobCondition">
                    <span>招{{$data->num}}人</span>
                    <span>本科</span>
                    <span>3-5年</span>
                </div>
                <div class="jobAddress">
                        <span class="city">
                            <i class="glyphicon glyphicon-map-marker">
                            </i>
                            <span>上海</span>
                        </span>
                    <span>{{$data->address}}</span>
                    <a href="javascript:void(0)" class="map">查看地图</a>
                </div>
                <div class="jobApply">
                    <a class="btn btn-warning btn-large applyJobBtn" href="javascript:void(0)">申请职位</a>
                    <span class="chatList">
                        <a class="chat" href="javascript:void(0)">
                            <i class="glyphicon glyphicon-headphones"></i>
                            <span class="chat_txt">微聊</span>
                        </a>
                        <a class="showPhoneBtn" href="javascript:void(0)">
                            <i class="glyphicon glyphicon-earphone"></i>
                            电话沟通
                        </a>
                    </span>
                </div>
                <div class="jobAdvice">
                    提示：刷信誉、淘宝刷钻、YY网络兼职、加YY联系的职位都是骗子！收取费用或押金都可能有欺诈嫌疑，请警惕！
                </div>
            </div>
            <div class="pull-right comDetail">
                <img src="/images/famous.png" alt="">
                <div class="company">
                    <p class="name"><a href="">{{$data->com_name}}</a></p>
                    <p class="firm"><span>名企</span><span>五年</span></p>
                    <p class="business"><a href="javascript:void(0)">互联网/电子商务</a></p>
                    <p class="scale">500-999人</p>
                    <div class="com_identify">
                        <p class="identify_title"><span>企业招聘(已认证企业)</span></p>
                        <p class="identify_con">
                            <span class="identify1"><i class="glyphicon glyphicon-briefcase"></i><span>普通企业认证</span></span>
                            <span class="identify2"><i class="glyphicon glyphicon-book"></i><span>普通实名认证</span></span></p>
                    </div>
                    <div class="com_statistics">
                        <p class="statistics_item">
                            <span class="item_num"><span>48</span>%</span>
                            简历反馈率
                        </p>
                        <p class="statistics_item">
                            <span class="item_num"><span>41</span>个</span>
                            招聘职位
                        </p>
                        <p class="statistics_item">
                            <span class="item_num"><span>65</span>月</span>
                            加入cool
                        </p>
                    </div>
                    <a href="javascript:void(0)" class="view">查看招聘职位</a>
                </div>
            </div>
            <div class="pull-left description">
                <div class="posDescription thePos">
                    {{$data->job_type}}
                    <h3>职位描述</h3>
                    <p>岗位职责：</p>
                    <p>1.负责公司平台产品的设计研发；</p>
                    <p>2.负责项目某个单元的产品功能需求分析、设计，开发工作；</p>
                    <p>3.负责系统架构设计和性能优化；</p>
                    <p>4.解决开发中遇到的关键问题和技术难题；</p>
                    <p>5.协调和指导的部分开发人员的开发工作；</p>
                    <p>6.协助保证研发工作的质量和进度，找出系统瓶颈，改进系统算法，提高系统性能；</p>
                    <p>7.参与公司重大项目的技术方案设计及技术评审；</p>
                    <p>8.遵守团队的代码格式、代码安全、代码结构的规定，编写易读、易维护、高效率的代码；</p>
                    <p>9.互联网前沿技术研究和新技术应用；</p>
                    <p>10.领导安排的其他工作任务。</p>
                    <p>岗位要求：</p>
                    <p>1.精通PHP开发语言，熟悉面向对象的软件设计方法，五年以上PHP项目开发经验；</p>
                    <p>2.熟悉WebService的调用，熟悉PHP多线程技术；</p>
                    <p>3.熟悉Linux操作，常用命令，熟悉Shell脚本，以及LNMP环境；</p>
                    <p>4.熟练掌握XHTML、DIV+CSS、JavaScript等页面技术；</p>
                    <p>5.精通MySQL数据库应用开发，精通MySQL的数据库配置管理、性能优化等基本操作技能；</p>
                    <p>6.熟悉各种缓存技术，熟悉高性能的数据库系统的应用开发，有大规模高并发访问的应用开发经验；</p>
                    <p>7.熟悉J2EE开发更佳，包括：Struts、Spring、MyBatis、webservice、velocity等主流开发框架；</p>
                </div>
                <div class="lookMore lookMoreDos">
                    <span>查看更多<i class="glyphicon glyphicon-menu-right"></i></span>
                </div>
                <div class="comDescription theCom">
                    <h3>公司介绍</h3>
                    <p>钱多多（d.com.cn）成立于2013年10月8日,隶属于上海旭胜金融信息服务股份有限公司，是一家国内专业提供融资需求撮合业务的企业。公司集线上多元化融资业务于一体，为小微企业、金融机构以及个人提供专业、透明、高效的金融信息服务。公司总部位于上海浦东自由贸易区，经过三年多的发展，我们凭借严密的风控体系和资深的业务整合能力，在业界已具有较高的知名度。</p>
                    <p>钱多多自成立以来基于平台成熟的房产抵押贷款模式，一直追求着精益求精的业务体系建设。同时为搭建安全、有效的风控业务模型，公司高薪聘请了多名拥有10余年金融行业从业经验的专员，建立了一套行之有效的金融风控体系，从一定程度上增加投资人的资金安全。</p>
                    <p>作为一家专注于抵押贷款模式的网贷平台，钱多多在确保现有业务稳定发展的基础上，不断完善运营模式，积累符合自身的管理经验，整合行业资源，加大互联网技术开发与应用，强化品牌知名度与影响力建设，力求打造成集多元化、标准化、信息化为一体的综合性金融服务平台。</p>
                    <p>钱多多将在今后合规化运营过程中，一方面通过对用户信息的数据归集与分析，进一步确定自身平台的市场定位，抓住与公司自身业务模式相契合的客户群体并进行深耕细作，同时在符合相关法律法规的前提下适时开发新型网贷服务模式和产品，提高平台业务水平与服务质量；另一方面在保证与第三方机构紧密合作的前提下，根据企业发展实际情况对业务进行拓展，进一步提高平台核心竞争力。</p>
                    <p>让互联网金融变得安全、透明、高效，是我们矢志不渝的追求；让普惠金融服务实体、个体和社会，是我们不忘初心的夙愿。迎着互联网金融蓬勃发展的春风，锐意进取、开拓创新，网贷行业篇章需要我们共同书写！</p>
                </div>
                <div class="lookMore lookMoreCom">
                    <span>查看更多<i class="glyphicon glyphicon-menu-right"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/flexible.js"></script>
<script>
    $(function(){
        $(".lookMoreDos").on("click",function(){
            $(this).css("display","none");
            $(".posDescription").removeClass("thePos")
        });
        $(".lookMoreCom").on("click",function(){
            $(this).css("display","none");
            $(".comDescription").removeClass("theCom")
        });
    })
</script>
@endsection