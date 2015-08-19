@extends('app', ['subtitle'=>"绑定设备"])

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12 col-sm-offset-3">
            <br/>
            <img src="data:image/png;base64, {{ base64_encode(QrCode::margin(1)->format('png')->size(250)->generate(url('qrcode/auth', $token->value))) }} "
                 height="250px" width="250px">

            <p>
                请使用PushApp客户端 <code>扫描二维码</code>. 绑定完成?
                <a href="{{ url('/install') }}" class="btn btn-blue btn-flat">开始安装 >></a>
            </p>

            <p>
                如果还没有安装客户端，使用任意App扫描会打开<a href="{{env('APP_DOWNLOAD_URL', 'http://fir.im/pushapp')}}">下载页面</a>
            </p>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection