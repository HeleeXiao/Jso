@extends("man.layouts.manager")
@section("title","前台用户审核 - ".config('app.name'))

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="block full">
                <div class="block-title">
                    <h2>用户搜索</h2>
                </div>
                <form action="{{ route("manager.us.index") }}" method="get" id="search-form">
                    <input name="keywords" type="text" value="{{ request("keywords") }}"
                           placeholder="尝试查询 [ E-mail 、名称 、电话 ...] ， 键入回车键开始查询 。 "
                           class="js-icon-search form-control input-lg">
                </form>
            </div>
        </div>
    </div>
    <table id="example-datatable" class="table table-striped table-bordered table-vcenter dataTable no-footer" role="grid" aria-describedby="example-datatable_info">
        <thead>
            @if($list)
                <tr role="row">
                    <th class="text-center sorting_asc">昵称</th>
                    <th class="text-center sorting_asc">Email</th>
                    <th class="text-center sorting_asc">注册IP</th>
                    <th class="text-center sorting_asc">电话</th>
                    <th class="text-center sorting_asc">类型</th>
                    <th class="text-center sorting_asc">状态</th>
                    <th class="text-center sorting_asc"></th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach($list as $user)
                <tr>
                    <td class="text-center sorting_asc"> {{ $user->nikename }} </td>
                    <td class="text-center sorting_asc"> {{ $user->email }} </td>
                    <td class="text-center sorting_asc"> {{ $user->register_ip }} </td>
                    <td class="text-center sorting_asc"> {{ $user->mobile }} </td>
                    <td class="text-center sorting_asc"> {{ $type[ $user->type ] }} </td>
                    <td class="text-center sorting_asc"> {{ $status[ $user->status ] }} </td>
                    <td class="text-center sorting_asc">
                        @if($user->type != 3)
                            <form style="display:inline-block" action="{{ route("manager.us.setType",['id' => $user->user_id ]) }}" method="post" id="set-type-{{ $user->user_id }}">
                                {{ csrf_field() }}
                                <a data-toggle="tooltip"  title="" data-original-title="设置为商家用户"
                                   class="btn btn-effect-ripple btn-xs btn-primary"
                                   onclick="layer.confirm('即将修改用户状态为商家用户，你确认吗 ?',{
                                        btn:['确定', '取消'],
                                        title:'警告',
                                        icon:0
                                        },function(index, layer){
                                           $('#set-type-{{ $user->user_id }}').submit();
                                           layer.closeAll();
                                           layer.load(2);
                                        }
                                        ,function(index, layer){
                                            layer.closeAll();
                                        }); return false;">
                                    <i class="fa fa-minus-circle"></i>
                                </a>
                            </form>
                        @else
                            <form style="display:inline-block" action="{{ route("manager.us.setType",['id' => $user->user_id ]) }}" method="post" id="set-type2-{{ $user->user_id }}">
                                {{ csrf_field() }}
                                <a data-toggle="tooltip"  title="" data-original-title="设置为普通用户"
                                   class="btn btn-effect-ripple btn-xs btn-success"
                                   onclick="layer.confirm('即将修改用户状态为普通用户，你确认吗 ?',{
                                            btn:['确定', '取消'], title:'警告', icon:0
                                           },function(index, layer){
                                                $('#set-type2-{{ $user->user_id }}').submit();
                                               layer.closeAll();
                                               layer.load(2);
                                           }
                                           ,function(index, layer){
                                                layer.closeAll();
                                           }); return false;">
                                    <i class="fa fa-minus-circle"></i>
                                </a>
                            </form>
                        @endif

                        @if(!$user->status)
                            <form style="display:inline-block" action="{{ route("manager.us.setStatus",['id' => $user->user_id ]) }}" method="post" id="set-user-{{ $user->user_id }}">
                                {{ csrf_field() }}
                                <a data-toggle="tooltip"  title="" data-original-title="禁用该用户"
                                   class="btn btn-effect-ripple btn-xs btn-primary"
                                   onclick="layer.confirm('即将禁用该用户，你确认吗 ?',{
                                           btn:['确定', '取消'], title:'警告', icon:0
                                           },function(index, layer){
                                                $('#set-user-{{ $user->user_id }}').submit();
                                           }
                                           ,function(index, layer){
                                                layer.closeAll();
                                           }); return false;">
                                    <i class="fa fa-user-times"></i>
                                </a>
                            </form>
                        @else
                            <form style="display:inline-block" action="{{ route("manager.us.setStatus",['id' => $user->user_id ]) }}" method="post" id="set-user2-{{ $user->user_id }}">
                                {{ csrf_field() }}
                                <a data-toggle="tooltip"  title="" data-original-title="启用该用户"
                                   class="btn btn-effect-ripple btn-xs btn-success"
                                   onclick="layer.confirm('即将启用该用户，你确认吗 ?',{
                                           btn:['确定', '取消'], title:'警告', icon:0
                                           },function(index, layer){
                                                $('#set-user2-{{ $user->user_id }}').submit()
                                           }
                                           ,function(index, layer){
                                                layer.closeAll();
                                           }); return false;">
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    @if($list)
        @include("man.layouts.paginate")
    @endif
@stop