@extends('app', ['subtitle'=>"推送历史"])

@section('content')
    <div class="card-wrap">
        @foreach($pushes as $push)
            <?php $package = $push->package; ?>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-xs-12 col-md-offset-2 center-block">
                    <div class="card">
                        <div class="card-main">
                            <div class="card-header">
                                <div class="card-header-side pull-left">
                                    <img alt="{{ $package->app_name }}" src="{{ $package->icon_url }}">
                                </div>
                                <div class="card-inner">
                                    <span>{{ $package->app_name }}</span>
                                </div>
                            </div>
                            {{--<div class="card-img">--}}
                            {{--<img alt="alt text" src="../images/samples/landscape.jpg">--}}
                            {{--</div>--}}
                            <div class="card-inner">
                                <div class="row">
                                        <span class="col-md-6">
                                        包名: {{ $package->package_name }}
                                        </span>
                                        <span class="col-md-6">
                                            版本: {{ $package->version_code }}({{ $package->version_name }})
                                        </span>
                                </div>

                                <p>
                                    大小: {{ friendly_filesize($package->file_size) }}

                                </p>
                            </div>
                            <div class="card-action">
                                <ul class="nav nav-list pull-left">
                                    <li>
                                        <a class="waves-attach waves-effect" href="javascript:void(0)"><span
                                                    class="icon text-alt">schedule</span>&nbsp;<span
                                                    class="text-alt">{{ friendly_date($push->created_at) }}</span></a>
                                    </li>
                                </ul>
                                <ul class="nav nav-list pull-right">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle waves-attach waves-effect"
                                           data-toggle="dropdown"><span
                                                    class="icon">keyboard_arrow_down</span></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="waves-attach waves-effect"
                                                   href="{{ $package->user_id == Auth::id() ? url('install/target').'?package_id='.$package->id : url('install/target').'?package='.$package->md5 }}">
                                                    <span class="icon icon-lg">replay all</span>&nbsp;再次安装
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-8 col-md-8 col-xs-12" >

            <div class="pull-right">
                <?php echo $pushes->render() ?>
            </div>
        </div>

    </div>
@endsection