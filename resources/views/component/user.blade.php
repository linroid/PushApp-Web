<nav class="menu menu-right" id="profile">
    <div class="menu-scroll">
        <div class="menu-wrap">
            <div class="menu-top">
                <div class="menu-top-img">
                    <img alt="{{ Auth::user()->nickname }}" src="{{ asset('images/samples/landscape.jpg') }}">
                </div>
                <div class="menu-top-info">
                    <a class="menu-top-user" href="javascript:void(0)"><span class="avatar pull-left">
                            <img alt="{{ Auth::user()->nickname }}"
                                 src="{{ Auth::user()->avatar }}"></span>{{ Auth::user()->nickname }}
                    </a>
                </div>
                {{--<div class="menu-top-info-sub">--}}
                    {{--<small>Some additional information about John Smith</small>--}}
                {{--</div>--}}
            </div>
            <div class="menu-content">
                <ul class="nav">
                    <li>
                        <a href="{{ url('/profile') }}"><span class="icon icon-lg">account_box</span>账号设置</a>
                    </li>
                    <li>
                        <a href="{{ url('/download') }}"><span class="icon icon-lg">account_box</span>下载App</a>
                    </li>
                    <li>
                        <a href="{{ url('/auth/logout') }}"><span class="icon icon-lg">exit_to_app</span>退出</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
