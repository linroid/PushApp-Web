@extends('app', ['subtitle'=>"What's it"])

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12 pull-right">
            <div class="card">
                <div class="card-main">
                    <div class="card-inner">
                        <p class="card-heading text-blue">社交授权</p>
                        <p>
                            <a href="{{ url('auth/social').'?platform=github' }}"><span class="icon icon-5x"><i
                                            class="fa fa-github"></i></span></a>
                            or &nbsp;
                            <a href="{{ url('auth/social').'?platform=weibo'}}"><span class="icon icon-5x text-red"><i
                                            class="fa fa-weibo"></i></span></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-main">
                    <div class="card-inner">
                        <p class="card-heading text-blue">账号授权</p>
                        <p>
                            <a href="{{ url('auth/login')}}">登录</a>
                            &nbsp; ／ &nbsp;
                            <a href="{{ url('auth/register')}}">注册</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6  col-xs-12 pull-left">
            <blockquote>
                我是来帮你装app的 ！
            </blockquote>
            <section class="content-inner">
                <h2 class="content-sub-heading">场景1</h2>

                <p>开发好app后，需要做适配测试，一台一台地下载、安装？</p>

                <p>通过PushApp, 鼠标点几下即可自动完成</p>

                <h2 class="content-sub-heading">场景2</h2>

                <p>
                    虽然有Google Play、豌豆荚这样的应用市场可以将App推送到手机上，但如果不是从这些地方下载的呢？
                </p>

                <p>通过PushApp，无需数据线即可轻松安装</p>

            </section>
        </div>
    </div>
@endsection