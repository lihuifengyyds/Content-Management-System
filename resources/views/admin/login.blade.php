<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin') }}/common/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/common/font-awesome-4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/common/toastr.js/2.1.4/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/css/main.css">
    <script src="{{ asset('admin') }}/common/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('admin') }}/common/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('admin') }}/common/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="{{ asset('admin') }}/js/main.js"></script>
    <title>登录</title>
</head>

<body class="login">
    <div class="container">
        {{-- 登录表单 --}}
        <form action="/admin/check" method="post" class="j-login">
            <h1>后台管理系统</h1>
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="用户名" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" required>
            </div>
            <div class="form-group">
                <input type="text" name="captcha" class="form-control" placeholder="验证码" required>
            </div>

            <div class="form-group">
                {{ csrf_field() }}
                <input type="submit" class="btn btn-lg btn-block btn-success" value="登录">
            </div>
            <div class="login-captcha">
                <img src="{{ captcha_src() }}" alt="captcha">
            </div>
        </form>

    </div>

    <script>
        $('.login-captcha img').click(function(){
            $(this).attr('src',$(this).attr('src') + '?_=' + Math.random());
        })
        (function (window, $, toastr){
            window.main = {
                token: '',
                toastr:toastr,
                init: function(opt){
                    $.extend(this,opt);
                    toastr.options.positionClass = 'toast-top-center';
                    return this;
                },
                ajax: function(opt, success, error){
                    opt = (typeof opt === 'string') ? {url: opt} : opt;
                    var that = this; 
                    var options = {
                        success: function(data, status, xhr){
                            that.hideLoading();
                            if(!data){
                                toastr.error('请求失败,请重试');
                            }else if(data.code === 0){
                                toastr.error(data.msg);
                                error && error(data);
                            }else {
                                success && success(data);
                            }
                            opt.success && opt.success(data,status, xhr);
                        },
                        error: function(xhr, status, err){
                            that.hideLoading();
                            toastr.error('请求失败，请重试');
                            opt.error && opt.error(xhr, status, err);
                        }
                    };
                    that.showLoading();
                    $.ajax($.extend({},opt,options));
                },
                showLoading: function(){
                    $('.main-loading').show();
                },
                hideLoading: function(){
                    $('.main-loading').hide();
                },
                // ajaxPost: function(opt, success, error){
                //     opt = (typeof opt === 'string') ? {url: opt} : opt;
                //     var that = this; 
                //     var callback = opt.success;
                //     opt.type = 'POST';
                //     opt.success = function(data,status,xhr){
                //         if(data && data,code === 1){
                //             toastr.success(data.msg);
                //         }
                //         callback && callback(data, status, xhr);
                //     };
                //     that.ajax(opt, success, error);
                // },
            };
        })(this,jQuery,toastr);

        main.ajaxForm('.j-login',function(){
            location.href = "/admin/index";
        });
    </script>

</body>

</html>
