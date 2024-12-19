<div class="header">
    <header>
        <div class="container">
            <a href="{{ url('/') }}" style="color: #000000">
                <div class="header-logo">
                    <span>内容</span>管理系统
                </div>
            </a>
            <div class="header-right">
                @if (session()->has('users.name'))
                    <li>
                        <a href="#" class="j-layout-pwd">
                            <i class="fa fa-user fa-fw"></i>{{ session()->get('users.name') }}
                        </a>
                    </li>
                    <li><a href="{{ url('logout') }}"><i class="fa fa-power-off fa-fw"></i>退出</a></li>
                @else
                    <li><a data-toggle="modal" data-target="#loginModal">登录</a></li>
                    <li><a data-toggle="modal" data-target="#registerModal">注册</a></li>
                @endif
            </div>
        </div>
    </header>
    {{-- 栏目列表 --}}
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container">
            <div></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @foreach ($category as $v)
                        @if (isset($v['sub']))
                            <li class="navitem dropdown">
                                <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    {{ $v['name'] }}
                                </a>
                                <div class="dropdown-menu">
                                    @foreach ($v['sub'] as $subv)
                                        <a class="dropdown-item" href="{{url('lists',['id'=>$v['id']])}}">{{ $v['name'] }}</a>
                                    @endforeach
                                </div>
                            
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{url('lists',['id'=>$v['id']])}}" class="nav-link">{{ $v['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</div>
{{-- 登录表单 --}}
<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">登录</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">$time;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="username">用户名</label>
                    <input type="text" name="name" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button tytpe="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary" id="login">立即登录</button>
            </div>
        </div>
    </div>
</div>
{{-- 注册表单 --}}
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">注册</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="usernamel">用户名</label>
                    <input type="text" name="name" class="form-control" id="usernamel">
                </div>
                <div class="form-group">
                    <label for="email">邮箱</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input type="password" name="password" id="passwordl" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm">确认密码</label>
                    <input type="password" class="form-control" id="confirm">
                </div>
            </div>
            <div class="modal-footer">
                {{ csrf_field() }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary" id="register">立即注册</button>
            </div>
        </div>
    </div>
</div>



<script>
    $('#register').on('click', function() {
        var data = {
            'name': $('#usernamel').val(),
            'email': $('#email').val(),
            'password': $('#passwordl').val(),
            'password_confirmation': $('#confirm').val(),
            '_token': "{{ csrf_token() }}"
        };

        $.post("{{ url('register') }}", data, function(result) {
            if (result.status == 1) {
                alert(result.msg);
                $('#registerModal').modal('hide');
            } else {
                alert(result.msg);
                return;
            }
        });
    });

    $('#login').on('click', function() {
        var data = {
            'name': $('#username').val(),
            'password': $('#password').val(),
            '_token': "{{ csrf_token() }}"
        };
        $.post("{{ url('login') }}", data, function(result) {
            if (result.status == 1) {
                alert(result.msg);
                window.location.reload();
            } else {
                alert(result.msg);
                return;
            }
        });
    });
</script>
