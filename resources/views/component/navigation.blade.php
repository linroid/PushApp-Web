<?php
    if(!isset($active)) {
        $active = null;
    }
    $is_active = function($module) use($active) {
        if($module == $active) {
            return 'class="active"';
        }
    }
?>
<header class="header">
    {{--<ul class="nav nav-list pull-left">--}}
    {{--<li>--}}
    {{--<a data-toggle="menu" href="#menu">--}}
    {{--<span class="icon icon-lg">menu</span>--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--</ul>--}}
    <a class="header-logo" href="{{ url('/') }}">PushApp</a>
    @if(Auth::check())
    <nav class="tab-nav tab-nav-offwhite pull-right">
        <ul class="nav nav-list">
            <li {!! $is_active('install') !!}>
                <a class="waves-effect waves-light"  href="{{ url('/') }}">安装</a>
            </li>
            <li {!! $is_active('device') !!}>
                <a class="waves-effect waves-light"  href="{{ url('/device') }}">设备</a>
            </li>
            <li {!! $is_active('history') !!}>
                <a class="waves-effect waves-light"  href="{{ url('/history') }}">历史</a>
            </li>
            <li>
                <a data-toggle="menu" href="#profile">
                    <span class="access-hide">{{Auth::user()->nickname}}</span>
                    <span class="avatar"><img alt="{{Auth::user()->nickname}}" src="{{Auth::user()->avatar}}"></span>
                </a>
            </li>
        </ul>
    </nav>
    @endif
</header>