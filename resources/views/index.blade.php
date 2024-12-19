<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('common/static')
    <title>首页</title>
</head>
<body>
    @include('common.header')

    <div class="main">
        <div class="container">
            <div class="row mt-4">
                {{-- 轮播图 --}}
                <div class="col-md-6 main-carousel">
                    <div class="carousel slide" id="carouselExampleCaptions" data-ride="carousel">
                        {{-- 添加指示器 --}}
                        <ol class="carousel-indicators">
                            @foreach($recommend as $k=>$con)
                                <li data-target="#carouselExampleCaptions" data-slide-to="{{$k}}" class="{{$k==0 ? 'active' : ''}}"></li>
                            @endforeach
                        </ol>
                        
                        <div class="carousel-inner">
                            @foreach ($recommend as $k=>$con)
                                <div class="carousel-item {{$k==0 ? 'active' : ''}}">
                                    <img src="/static/upload/{{$con->image}}" class="d-block w-100" alt="{{$con->title}}">
                                    <a href="{{url('detail',['id'=>$con->id])}}">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{$con->title}}</h5>
                                            <p>{!! str_limit($con->content,100) !!}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                {{-- 广告位 --}}
                <div class="col-md-6">
                    <div class="row main-imgbox">
                        @foreach ($adv as $adval)
                            <div class="col-md-6">
                                <a href="{{$adval['url']}}">
                                    <img src="/static/upload/{{$adval['image']}}" alt="Advertisement" class="img-fluid">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        {{-- 栏目内容 --}}
                        @foreach ($list as $value)
                            <div class="col-md-6 mb-4">
                                <div class="card main-card">
                                    <div class="card-header">
                                        <h2>{{$value->name}}</h2>
                                        <span class="float-right">
                                            <a href="{{url('lists',['id' => $value->id])}}">[查看更多]</a>
                                        </span>
                                    </div>
                                    @foreach ($value->content as $val)
                                        <div class="card-body">
                                            <div class="main-card-pic">
                                                <a href="#">
                                                    <img src="/static/upload/{{$val->image}}" alt="" class="img-fluid">
                                                    <span><i class="fa fa-search"></i></span>
                                                </a>
                                            </div>
                                            <div class="main-card-info">
                                                <span><i class="fa fa-calendar"></i>
                                                    {{date('Y-m-d',strtotime($val->created_at))}}
                                                </span>
                                                <h3><a href="/article/{{$val->id}}">{{$val->title}}</a></h3>
                                                <div class="main-card-desc">
                                                    {!!str_limit($val->content,100)!!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                {{-- 侧边栏 --}}
                @include('common.sidebar')
            </div>
        </div>
    </div>
    @include('common.footer')
</body>
</html>