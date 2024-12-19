<div class="card main-card main-card-sidebar">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">热门内容</h2>
        <a href="#" class="text-muted">[查看更多]</a>
    </div>
    <div class="card-body p-2">
        <div class="row g-2">
            @foreach ($hotContent as $val)
                <div class="col-6">
                    <div class="hot-content-item">
                        <div class="img-wrapper">
                            <a href="{{url('detail',['id'=>$val->id])}}">
                                <img src="/static/upload/{{$val->image}}" alt="{{$val->title}}" class="w-100">
                            </a>
                        </div>
                        <div class="content-info">
                            <h3><a href="{{url('detail',['id'=>$val->id])}}" class="text-dark">{{$val->title}}</a></h3>
                            <div class="meta">
                                <span class="date">{{date('Y-m-d',strtotime($val->created_at))}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.hot-content-item {
    margin-bottom: 15px;
}
.hot-content-item .img-wrapper {
    position: relative;
    padding-bottom: 75%;
    overflow: hidden;
    margin-bottom: 8px;
}
.hot-content-item .img-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.hot-content-item h3 {
    font-size: 14px;
    margin: 0 0 5px;
    line-height: 1.4;
}
.hot-content-item h3 a {
    text-decoration: none;
}
.hot-content-item .meta {
    font-size: 12px;
    color: #999;
}
</style>

{{-- <div class="card main-card main-card-sidebar">
    <div class="card-header"><h2>热门内容</h2></div>
    @foreach ($hotContent as $val)
        <div class="card-body p-2 border-bottom">
            <div class="main-card-pic mb-2">
                <a href="{{url('detail',['id'=>$val->id])}}">
                    <img src="/static/upload/{{$val->image}}" alt="{{$val->title}}" style="width:100%;height:150px;object-fit:cover;">
                </a>
            </div>
            <h3 class="mb-0" style="font-size:14px;">
                <a href="{{url('detail',['id'=>$val->id])}}" class="text-dark text-decoration-none">{{$val->title}}</a>
            </h3>
        </div>
    @endforeach
</div> --}}