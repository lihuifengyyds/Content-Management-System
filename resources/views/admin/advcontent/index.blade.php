@extends('admin/layouts/admin')
@section('title', '广告内容管理')
@section('main')
    <div class="main-title">
        <h2>
            @if (!empty($data))
                编辑
            @else
                添加
            @endif 广告
        </h2>
    </div>
    <div class="main-section form-inline">
        <a href="{{ route('advcontent.add') }}" class="btn btn-success">+ 新增</a>
    </div>
    <div class="main-section">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="75">序号</th>
                    <th>广告位名称</th>
                    <th>广告图片</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {{-- 广告位列表 --}}
                @foreach ($adv as $v)
                    <tr class="j-pid-{{ $v['pid'] }}">
                        <td><input type="text" value="{{ $v->id }}" class="form-control j-sort" maxlength="5"
                                style="height:25px;font-size:12px;padding:0 5px;"></td>
                        <td>{{ $v->position->name }}</td>
                        <td>
                            @foreach ($v->path as $val)
                                <img src="/static/upload/{{ $val }}" alt=""
                                    style="height: 40px;width:50px">
                            @endforeach
                        </td>
                        <td><a href="{{ url('advcontent/add', ['id' => $v->id]) }}" style="margin-right:5px;">编辑</a>
                            <a href="{{ url('advcontent/delete', ['id' => $v->id]) }}" class="j-del text-danger">删除</a>
                        </td>
                    </tr>
                @endforeach
                @if (empty($adv))
                    <tr>
                        <td colspan="4" class="text-center">还没有添加广告内容</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        main.menuActive('advcontent');

        $('.j-del').click(function() {
            if (confirm('您确定要删除此项吗？')) {
                var data = {
                    _token: '{{ csrf_token() }}'
                };
                main.ajaxPost({
                    url: $(this).attr('href'),
                    data: data
                }, function() {
                    location.reload();
                });
            }
            return false;
        });
    </script>
@endsection
