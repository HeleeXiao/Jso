@extends("man.layouts.manager")

@section("title","帖子列表 - ".config('app.name'))

@section("content")
    <!-- 首页内容下方 -->
    <div class="block full">
        <div class="block-title">
            <h2>帖子列表</h2>
        </div>
        <div class="table-responsive">
            <div id="example-datatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                <div class="row">
                    @include('man.layouts.limit')
                    @include('man.layouts.search')
                </div>
                <table id="example-datatable" class="table table-striped table-bordered table-vcenter dataTable no-footer" role="grid" aria-describedby="example-datatable_info">
                    <thead>
                    <tr role="row">
                        <th class="text-center sorting_asc" >标题</th>
                        <th class="text-center sorting_asc" >发布者</th>
                        <th class="text-center sorting_asc" >工作类别</th>
                        <th class="text-center sorting_asc" >招聘人数</th>
                        <th class="text-center sorting_asc" >工作地址</th>
                        <th class="text-center sorting_asc" >创建时间</th>
                        <th class="text-center sorting_asc" >状态</th>
                        <th class="text-center sorting_asc" ></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $status = [
                            '待审核',
                            '审核通过',
                            '驳回',
                            '置顶',
                            8=>'审核通过',
                        ];
                        $status_ui = [
                            'warning',
                            'success',
                            'primary',
                            'warning',
                            8=>'success',
                        ];
                    ?>
                    @foreach($list as $info)
                        <tr>
                            <td class="text-center sorting_asc"> {{ $info->title }} </td>
                            <td class="text-center sorting_asc"> {{ $info->master_nick_name }} </td>
                            <td class="text-center sorting_asc"> {{ $info->type }} </td>
                            <td class="text-center sorting_asc"> {{ $info->num }} </td>
                            <td class="text-center sorting_asc"> {{ $info->address }} </td>
                            <td class="text-center sorting_asc"> {{ \Carbon\Carbon::parse($info->created_at)->format('m-d H:i') }} </td>
                            <td class="text-center sorting_asc">
                                <a href="javascript:;" data-toggle="tooltip"
                                   class="btn btn-effect-ripple btn-xs btn-{{$status_ui[$info->status]}}" style="overflow: hidden; position: relative;">
                                    {{ $status[$info->status] }}
                                </a>
                            </td>
                            <td class=" sorting_asc">
                                <a href="{{ route("manager.ad.info",[ 'id' => $info->id ]) }}" data-toggle="tooltip" class="btn btn-effect-ripple btn-xs btn-info" style="overflow: hidden; position: relative;">
                                    预览
                                </a>
                                {{--@if( ! $info->status )--}}
                                    {{--<a href="" data-toggle="tooltip" class="btn btn-effect-ripple btn-xs label-warning" style="overflow: hidden; position: relative;">--}}
                                        {{--审核--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                                @if(!$info->status)
                                    <form style="display:inline-block" action="{{ route("manager.ad.setStatus",['id' => $info->id ]) }}" method="post" id="set-user-{{ $info->id }}">
                                        {{ csrf_field() }}
                                        <a data-toggle="tooltip"  title="" data-original-title="审核通过"
                                           class="btn btn-effect-ripple btn-xs btn-success"
                                           onclick="layer.confirm('即将审核通过，你确认吗 ?',{
                                                   btn:['确定', '取消'], title:'警告', icon:0
                                                   },function(index, layer){
                                                   $('#set-user-{{ $info->id }}').submit();
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
                @include('man.layouts.paginate')
            </div>
        </div>
    </div>
@stop