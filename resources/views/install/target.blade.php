@extends('app', ['subtitle'=>"选择设备"])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12 col-sm-offset-3">

                <section class="content-inner">
                    {{--<h2 class="content-sub-heading">列表</h2>--}}
                    <form action="{{ url('install/push') }}" method="post" class="form">
                        <input type="hidden" name="package_id" value="{{ $package->id }}"/>
                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>"/>

                        <button id="btn-select-none"
                                class="btn btn-sm waves-attach waves-button waves-light waves-effect"
                                type="button">全不选
                        </button>
                        <button id="btn-select-all"
                                class="btn btn-blue  btn-sm waves-attach waves-button waves-effect  pull-right"
                                type="button">全选
                        </button>
                        <div class="clearfix"></div>
                        <div class="tile-wrap">

                            @foreach($devices as $device)
                                <div class="tile">
                                    <div class="pull-left tile-side">
                                        <div class="avatar avatar-blue avatar-sm">
                                            <span class="icon">phone</span>
                                        </div>
                                    </div>
                                    <div class="tile-inner">
                                        <span>{{ $device->alias  }}</span>
                                    </div>
                                    <div class=" pull-right tile-side">
                                        <div class="checkbox checkbox-adv">
                                            <label for="device-{{$device->id}}">
                                                <input class="access-hide"
                                                       id="device-{{$device->id}}"
                                                       value="{{$device->id}}"
                                                       name="devices[]"
                                                       type="checkbox">
                                                <span class="circle"></span>
                                                <span class="circle-check"></span>
                                                <span class="circle-icon icon">done</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group form-group-label form-group-blue">
                            <div class="row">
                                <div class="col-lg-6 col-sm-8">
                                    <label class="floating-label" for="float-text-blue">你可以复制下面的链接给其他人哟</label>
                                    <input class="form-control" id="float-text-blue" type="text" value="{{ url('install/target').'?package='.$package->md5 }}">
                                </div>
                                <div class="col-lg-4 col-sm-4">

                                    <button class="btn btn-blue col-sm-offset-4 waves-attach waves-button waves-light waves-effect "
                                            type="submit">立即安装 >
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{--<button class="btn waves-attach waves-button waves-effect" type="button">取消--}}
                        {{--</button>--}}
                    </form>
                </section>
            </div>
        </div>

    </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#btn-select-all').click(function () {
            console.log($(this));
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.prop('checked', true);
        });
        $('#btn-select-none').click(function () {
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.prop('checked', false);
        });
    </script>
@endsection