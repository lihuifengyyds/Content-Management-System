@extends('admin/layouts/admin')
@section('title', '内容列表')
@section('main')
    <div class="main-title">
        <h2>内容管理</h2>
    </div>
    <div class="main-section form-inline">
        <a href="{{ url('content/add') }}" class="btn btn-success">+ 新增</a>
        {{-- 栏目下拉列表 --}}
        <select class="j-select form-control" style="main-width:120px;margin-left:8px">
            <option value="{{url('content')}}" {{ request('id') == null ? 'selected' : '' }}>所有栏目</option>
            @foreach ($category as $v)
                @if($v['level']) 
                    <option value="{{url('content', ['id' => $v['id']])}}" {{ request('id') == $v['id'] ? 'selected' : '' }}>
                        <small class="text-muted">--</small>{{$v['name']}}
                    </option>
                @else
                    <option value="{{url('content', ['id' => $v['id']])}}" {{ request('id') == $v['id'] ? 'selected' : '' }}>
                        {{$v['name']}}
                    </option>
                @endif
            @endforeach
        </select>
    </div>

     
    <div class="main-section">
        <form action="{{ url('category/sort') }}" class="j-form" method="post">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="75">序号</th>
                        <th>栏目</th>
                        <th>图片</th>
                        <th>标题</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th width="100">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content as $v)
                        {{-- 内容列表 --}}
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $v->category ? $v->category->name : '无分类' }}</td>
                            <td><img @if ($v->image) src="/static/upload/{{ $v->image }}" @else src="{{ asset('admin') }}/img/noimg.png" @endif
                                    width="50" height="50"></td>
                            <td>{{ $v->title }}</td>
                            <td>
                                @if ($v->status == 1)
                                    默认
                                @else
                                    推荐
                                @endif
                            </td>
                            <td>{{ $v->created_at }}</td>
                            <td><a href="{{ url('content/edit', ['id' => $v->id]) }}" style="margin-right:5px;">编辑</a>
                                <a href="{{ url('content/delete', ['id' => $v->id]) }}" class="j-del text-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    @if (empty($content))
                        <tr>
                            <td colspan="7" class="text-center">还没有添加内容</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ csrf_field() }}
        </form>
    </div>

    <script>
        main.menuActive('content');
        $('.j-del').click(function(){
            if(confirm('确定要删除吗？')){
                var data = {_token: '{{ csrf_token() }}'};
                main.ajaxPost({url:$(this).attr('href'),data:data},function(){
                    location.reload();
                });
            }
            return false;
        })
        $('.j-select').change(function(){
            window.location.href = $(this).val();
        })
    </script>
@endsection
