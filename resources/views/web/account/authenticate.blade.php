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
            <div class="col-md-8 col-md-offset-1" style="font-size: 16px;">
                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#person" id="person-tab" role="tab" data-toggle="tab" aria-controls="person" aria-expanded="true">个人类认证</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#enterprise" role="tab" id="enterprise-tab" data-toggle="tab" aria-controls="enterprise" aria-expanded="false">企业类认证</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#other" role="tab" id="other-tab" data-toggle="tab" aria-controls="other" aria-expanded="false">其他认证</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active in" role="tabpanel" id="person" aria-labelledby="person-tab">
                            <br />
                            <h3>Wechat</h3>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="enterprise" aria-labelledby="enterprise-tab">
                            <br />
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <h4 class="card-title">营业执照第三方认证</h4>
                                    <div style="margin-left: 15px;">
                                        <form class="form-horizontal" id="third_part_form" action="{{route('web.account.post.image')}}" method="post">
                                            <div class="form-group">
                                                <label></label>
                                                <input type="file" name="file" />
                                            </div>
                                            <div class="form-group">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="photo_type" value="1" />
                                                <button type="button" class="btn btn-primary" id="third_part_btn">submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card-body" style="border-top: 1px solid #ccc;">
                                    <h4 class="card-title">营业执照普通认证</h4>
                                    <div style="margin-left: 15px;">
                                        <form class="form-horizontal" action="{{route('web.account.post.image', 2)}}" method="post">
                                            <div class="form-group">
                                                <label></label>
                                                <input type="file" name="file" />
                                            </div>
                                            <div class="form-group">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="photo_type" value="2" />
                                                <button type="button" class="btn btn-primary" id="common_btn">submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="other" aria-labelledby="other-tab">
                            <br />
                            <h3>Others</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('web.default.footer')
@stop

@section('script')
    <script type="application/javascript" src="/js/jquery.form.min.js"></script>
    <script>
        $(function () {
            $('#third_part_btn').click(function () {
                var that = $(this);
                $('#third_part_form').ajaxSubmit({
                    beforeSubmit: function () {
                        that.attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (! response.status) {
                            alert('上传成功');
                        }
                    },
                    complete: function () {
                        that.removeAttr('disabled');
                    }
                });
            });
        });
    </script>

@stop