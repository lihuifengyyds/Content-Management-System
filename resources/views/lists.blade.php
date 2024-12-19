<!DOCTYPE html>
<html lang="en">
<head>
    @include('common/static')
    <title>列表页</title>
</head>
<body>
    @include('common/header')
    <div class="main">
        <div class="main-crumb">
            <div class="container">
                {{-- 面包导航 --}}
                <nav aria-label="breadcrumb">
                    {!! Breadcrumbs::render('category', $id) !!}
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    {{-- 内容列表 --}}
                    @foreach($content as $con)
                        <div class="col-md-6 mb-4">
                            <div class="card main-card">
                                <div class="main-card-pic">
                                    <a href="{{url('detail',['id'=>$con->id])}}">
                                        <img src="@if($con->image)/static/upload/{{$con->image}} @else {{asset('admin')}}/img/noimg.png @endif" alt="">
                                        <span><i class="fa fa-search"></i></span>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="main-card-info">
                                        <span><i class="fa fa-calendar"></i>
                                        {{date('Y-m-d',strtotime($con->created_at))}}</span>
                                        <span><i class="fa fa-comments">{{$con->comment->count()}}</i>
                                        0</span>
                                    </div>
                                    <h3><a href="{{url('detail',['id'=>$con->id])}}">{{$con->title}}</a></h3>
                                    <div class="main-card-desc">
                                        {!!str_limit($con->content,100)!!}
                                    </div>
                                </div>
                                <a href="{{url('detail',['id'=>$con->id])}}" class="main-card-btn">阅读全文</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{$content->links()}}
            </div>
            <div class="col-md-3">
                {{-- 侧边栏 --}}
                @include('common.sidebar')
            </div>
        </div>
    </div>
    @include('common/footer')
</body>
</html>