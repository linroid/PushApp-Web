@extends('app', ['subtitle'=>"设备列表"])

@section('content')
<div class="container">
    <div class="card-wrap">
    <div class="row">
        @foreach($devices as $device)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-main">
                        <div class="card-inner">
                            <p class="card-heading">{{ $device->alias }}</p>

                            <p class="row">
                                <span class="col-lg-6">型号: {{$device->model}}</span>
                            <span class="col-lg-6">系统: {{ $device->os_name }} ({{ $device->sdk_level }}
                                )</span>
                            </p>

                            <p class="row">

                                <span class="col-lg-6">分辨率: {{$device->width}}x{{ $device->height }}</span>
                                <span class="col-lg-6">DPI: {{$device->dpi}}</span>

                            </p>

                            <p class="row">
                    <span class="col-lg-6">网络: @if($device->network_type == 'wifi')
                            <span class="icon text-alt">wifi</span>
                        @elseif($device->network_type == 'mobile')
                            <i class="fa fa-mobile text-yellow"></i>
                        @else 未知
                        @endif </span>
                            </p>
                        </div>
                        <div class="card-action">
                            <ul class="nav nav-list pull-left">
                                <li>
                                    <a href="javascript:void(0)"><span class="icon">send</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><span class="icon">delete</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown"><span class="icon">settings</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0)"><span class="icon margin-right-half">loop</span>&nbsp;Lorem
                                                Ipsum</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><span class="icon margin-right-half">replay</span>&nbsp;Consectetur
                                                Adipiscing</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><span class="icon margin-right-half">shuffle</span>&nbsp;Sed
                                                Ornare</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <?php echo $devices->render() ?>
    </div>
    </div>
</div>
@include('component.fab')
@endsection