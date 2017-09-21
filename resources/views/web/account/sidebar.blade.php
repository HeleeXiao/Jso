<div class="col-md-2 col-md-offset-1">
    <ul class="list-group text-center">
        <li class="list-group-item @if($flag == 0) active @endif">
            <h4>
                <a href="{{route('web.account.profile')}}">个人资料</a>
            </h4>
        </li>
        <li class="list-group-item @if($flag == 1) active @endif">
            <h4>
                <a href="{{route('web.account.bind-account')}}">帐号绑定</a>
            </h4>
        </li>
        <li class="list-group-item @if($flag == 2) active @endif">
            <h4>
                <a href="{{route('web.account.authenticate')}}">认证管理</a>
            </h4>
        </li>
        <li class="list-group-item @if($flag == 3) active @endif">
            <h4>
                <a href="{{route('web.password.modify.form')}}">密码设置</a>
            </h4>
        </li>
        <li class="list-group-item @if($flag == 4) active @endif">
            <h4>
                <a href="">消息管理</a>
            </h4>
        </li>
    </ul>
</div>