<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="initial-scale=1.0, width=device-width" name="viewport">
    <title>PushApp - 快速安装app到多个设备!</title>

    <!-- css -->
    <link href="{{ asset('css/base.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
            <!-- ie -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.min.js')}}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="avoid-fout page-blue">
<div class="avoid-fout-indicator avoid-fout-indicator-fixed">
    <div class="progress-circular progress-circular-blue progress-circular-center">
        <div class="progress-circular-wrapper">
            <div class="progress-circular-inner">
                <div class="progress-circular-left">
                    <div class="progress-circular-spinner"></div>
                </div>
                <div class="progress-circular-gap"></div>
                <div class="progress-circular-right">
                    <div class="progress-circular-spinner"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('component.navigation')
@if(Auth::check())
    @include('component.user')
@endif
<div class="content">
    <div class="content-heading">
        <div class="container">
            <h1 class="heading">{{ $subtitle }}</h1>
        </div>
    </div>

    <div class="container">
        <div class="content-inner">
            @yield('content')
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p>PushApp</p>
    </div>
</footer>
{{--@include('component.fab')--}}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/base.js') }}"></script>
@include('component.toast')
@yield('script')

</body>
</html>