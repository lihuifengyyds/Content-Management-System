<!DOCTYPE html>
<html lang="en">

<head>
    @include('common/static')
    <title>详细页</title>
</head>

<body>
    @include('common/header')
    <div class="main">
        <div class="main-crumb">
            <div class="container">
                {{-- 面包导航 --}}
                <nav aria-label="breadcrumb">
                    {!! Breadcrumbs::render('detail', ['id' => $id, 'cid' => $cid]) !!}
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    {{-- 内容区域 --}}
                    <article class="main-article">
                        <header>
                            <h1>{{ $content->title }}</h1>
                            <div>发表于{{ date('Y-m-d', strtotime($content->created_at)) }}</div>
                        </header>
                        <div class="main-article-content">
                            <p>
                                <img src="/static/upload/{{ $content->image }}" class="img-fluid">
                            </p>
                            <p>{!! $content->content !!}</p>
                        </div>
                        {{-- 点赞板块 --}}
                        @if (session()->has('users'))
                            <div class="main-article-like">
                                <span>
                                    <i class="fa fa-thumbs-up" aria-hidden="true">{{ $count }}</i>
                                </span>
                            </div>
                        @endif
                    </article>
                    <div class="main-comment">
                        {{-- 评论区域 --}}
                        @if(!$comments->isEmpty())
                            <div class="main-comment-header">
                                <span id="count">{{$comments->count()}}</span>条评论
                            </div>
                            @foreach($comments as $val)
                            <div class="main-comment-item">
                                <div class="main-comment-name">{{$val->user->name}}</div>
                                <div class="main-comment-date">
                                    {{date('Y-m-d',strtotime($val->created_at))}}</div>
                                    <div class="main-comment-content">
                                        {{$val->content}}
                                    </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- 发表评论表单 --}}
                    <div class="main-reply">
                        @if(session()->has('users')) 
                            <div class="main-reply-header">发表评论</div>
                            <div class="main-reply-title">评论内容</div>
                            <div>
                                <textarea name="content" id="content" cols="30" rows="8"></textarea>
                            </div>
                            <div>
                                <input type="hidden" id="c_id" value="{{$id}}">
                                <input type="button" value="提交评论" id="publish">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    {{-- 侧边栏 --}}
                    @include('common.sidebar')
                </div>
            </div>
        </div>
    </div>
    @include('common/footer')
</body>

</html>

<script>
    $('.fa-thumbs-up').on('click', function() {
        var $this = $(this);
        $.get("{{ url('like', $id) }}", {}, function(result) {
            if (result.status === '1') {
                $this.text(result.count);
                alert(result.msg);
            } else {
                alert(result.msg);
            }
        }).fail(function() {
            alert('请求失败，请检查网络连接。');
        });
    });

    $(document).ready(function(){
        $('#publish').on('click', function(){
            var content = $('#content').val();
            if (!content.trim()) {
                alert('请输入评论内容');
                return;
            }
            
            var data = {
                'cid': $('#c_id').val(),
                'content': content
            };
            
            $.get("{{url('comment')}}", data, function(result){
                if (result.status === '1') {
                    var data = result.data;
                    var html = '<div class="main-comment-item">' +
                        '<div class="main-comment-name">' + data.user + '</div>' +
                        '<div class="main-comment-date">' + data.created_time + '</div>' +
                        '<div class="main-comment-content">' + data.content + '</div>' +
                        '</div>';
                    
                    if ($(".main-comment-header").length === 0) {
                        $(".main-comment").prepend('<div class="main-comment-header"><span id="count">1</span>条评论</div>');
                    }
                    
                    $(".main-comment-header").after(html);
                    $('#count').text(data.count);
                    $('#content').val(''); // 清空输入框
                    alert(result.msg);
                } else {
                    alert(result.msg || '评论失败');
                }
            }).fail(function() {
                alert('请求失败，请检查网络连接');
            });
        });
    });
</script>
