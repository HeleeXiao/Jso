<style>
    body{
        font-family: 微软雅黑;
        font-size: 16px;
        color: #666;
        text-align: center;
    }
    .title{
        float: left;
        width: 100%;
        text-align: left;
        padding: 10px;
        border-bottom: #ccc solid 2px;
        margin-bottom: 5px;
    }
    .rows{
        float: left;
        width: 100%;
        text-align: left;
        border-bottom: #ccc solid 1px;
    }
    .rows_l{
        float: left;
        width: 100px;
        text-align: left;
        padding: 10px;
    }
    .rows_r{
        float: left;
        text-align: left;
        padding: 10px;
    }
    input{
        border:1px solid #ccc;
        height: 26px;
        width: 250px;
        padding-left: 10px;
    }
    select{
        border:1px solid #ccc;
        height: 26px;
        width: 250px;
        padding-left: 10px;
    }
    .submit{
        margin-top: 30px;
        background-color: orange;
        border-radius: 5px;
        height: 36px;
        color: white;
    }
</style>
<div style="float: left;width: 100%;float: left">
    <div class="title">
        修改企业招聘信息
    </div>
    <form action="{{url('/ad/update')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="id" value="{{ $data->id }}" />
        <div class="rows">
            <div class="rows_l">公司名称:</div>
            <div class="rows_r"><input type="text" id="company_name" name="company_name" size="100" value="{{$data->company_name}}"/></div>
        </div>
        <div class="rows">
            <div class="rows_l">职位名称:</div>
            <div class="rows_r"><input type="text" id="job_name" name="job_name" size="100" value="{{$data->job_name}}"/></div>
        </div>
        <div class="rows">
            <div class="rows_l">职位类别:</div>
            <div class="rows_r">
                <select id="type" name="type">
                    <option value="1">CEO</option>
                    <option value="2">COO</option>
                    <option value="3">CFO</option>
                    <option value="4">CTO</option>
                </select>
            </div>
        </div>
        <div class="rows">
            <div class="rows_l">区域:</div>
            <div class="rows_r">
                <select id="area_city_level_id" name="area_city_level_id">
                    @foreach($area as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <select id="area_first_level_id" name="area_first_level_id">
                    @foreach($city as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="rows">
            <div class="rows_l">招聘人数:</div>
            <div class="rows_r"><input type="number" id="num" name="num" size="100" value="{{$data->num}}"/></div>
        </div>
        <div class="rows">
            <div class="rows_l">学历要求:</div>
            <div class="rows_r">
                <select id="ed" name="ed">
                    <option value="1">小学</option>
                    <option value="2">初中</option>
                    <option value="3">高中</option>
                    <option value="4">中专</option>
                    <option value="5">大专</option>
                    <option value="6">大学</option>
                    <option value="7">研究生</option>
                    <option value="8">博士</option>
                    <option value="9">博士后</option>
                </select>
            </div>
        </div>
        <div class="rows">
            <div class="rows_l">工作年限:</div>
            <div class="rows_r">
                <select id="work_years" name="work_years">
                    <option value="1">1年</option>
                    <option value="2">2年</option>
                    <option value="3">3年</option>
                    <option value="5">5年</option>
                </select>
            </div>
        </div>
        <div class="rows">
            <div class="rows_l">每月薪资:</div>
            <div class="rows_r">
                <select id="money" name="money">
                    <option value="500">500元</option>
                    <option value="1000">1000元</option>
                    <option value="1500">1500元</option>
                    <option value="2000">2000元</option>
                </select>
            </div>
        </div>
        {{--<div class="rows">--}}
            {{--<div class="rows_l">任职要求:</div>--}}
            {{--<div class="rows_r"><input id="job_requirements" name="job_requirements" size="100" value="{{$data->job_requirements}}"/></div>--}}
        {{--</div>--}}
        <div class="rows">
            <div class="rows_l">内容:</div>
            <div class="rows_r"><input id="description" name="description" size="100" value="{{$data->description}}"/></div>
        </div>
        {{--<div class="rows">--}}
            {{--<div class="rows_l">福利待遇:</div>--}}
            {{--<div class="rows_r">--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="treatment[wxyj]" id="treatment_wxyj" value="wxyj" @if($data->treatment_wxyj) checked @endif/>--}}
                    {{--五险一金--}}
                {{--</label>--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="treatment[bc]" id="treatment_bc" value="bc" @if($data->treatment_bc) checked @endif/>--}}
                    {{--包吃--}}
                {{--</label>--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="treatment[bz]" id="treatment_bz" value="bz" @if($data->treatment_bz) checked @endif/>--}}
                    {{--包住--}}
                {{--</label>--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="treatment[zmsx]" id="treatment_zmsx" value="zmsx" @if($data->treatment_zmsx) checked @endif/>--}}
                    {{--周末双休--}}
                {{--</label>--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="treatment[ndsx]" id="treatment_ndsx" value="ndsx" @if($data->treatment_ndsx) checked @endif/>--}}
                    {{--年底双薪--}}
                {{--</label>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="rows">
            <div class="rows_l">联系人:</div>
            <div class="rows_r"><input id="contacts" name="contacts" size="100" value="{{$data->contacts}}"/></div>
        </div>
        <div class="rows">
            <div class="rows_l">联系电话:</div>
            <div class="rows_r"><input id="tel" name="tel" size="100" value="{{$data->tel}}"/></div>
        </div>
        <div class="rows">
            <div class="rows_l">接收简历邮箱:</div>
            <div class="rows_r"><input id="email" name="email" size="100" value="{{$data->email}}"/></div>
        </div>
        <div class="rows">
            <div class="rows_l">工作地址:</div>
            <div class="rows_r"><input id="address" name="address" size="100" value="{{$data->address}}"/></div>
        </div>
        <a class="rows" style="height: 100px;border-bottom: 0px;">
            <input class="submit" type="submit" value=" 提 交 " onclick="">
            @if(Session::has('message'))
                <a style="color: red">{{Session::get('message')}}{{Session::get('level')}}</a>
            @endif
        </div>
    </form>
</div>
<script>
    {{--document.getElementById('type').value="{{$data->type}}";--}}
    {{--document.getElementById('area_city_level_id').value="{{$data->area_city_level_id}}";--}}
    {{--document.getElementById('area_first_level_id').value="{{$data->area_first_level_id}}";--}}
    {{--document.getElementById('ed').value="{{$data->ed}}";--}}
    {{--document.getElementById('work_years').value="{{$data->work_years}}";--}}
    {{--document.getElementById('money').value="{{$data->money}}";--}}
</script>