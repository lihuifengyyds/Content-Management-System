@extends('admin/layouts/admin')
@section('title', '广告位列表')
@section('main')
    <div class="main-title">
        <h2>广告位列表</h2>
    </div>
    <div class="main-section form-inline">
        <a href="{{ url('adv/add') }}" class="btn btn-primary">+ 新增</a>
    </div>
    <div class="main-section">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="75">序号</th>
                    <th>广告位名称</th>
                    <th width="100">操作</th>
                </tr>
            </thead>
            <tbody>
                {{-- 广告位列表 --}}
                @foreach ($adv as $v)
                    <tr>
                        <td>{{ $v->id }}</td>
                        <td>{{ $v->name }}</td>
                        <td>
                            <a href="{{ url('adv/add', ['id' => $v->id]) }}" style="margin-right: 5px;">编辑</a>
                            <a href="{{url('adv/delete', ['id' => $v->id])}}" class="j-del text-danger">删除</a>
                        </td>
                    </tr>
                @endforeach
                @if (empty($adv))
                    <tr>
                        <td colspan="4" class="text-center">还没有添加广告位</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <script>
        main.menuActive('adv');
        $('.j-del').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var $row = $this.closest('tr');
            var advName = $row.find('td:nth-child(2)').text().trim();
            
            if (confirm('您确定要删除"' + advName + '"广告位吗？删除后不可恢复！')) {
                $.ajax({
                    url: $this.attr('href'),
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 1) {
                            // 删除成功后平滑移除该行
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                // 检查是否还有其他广告位
                                if ($('tbody tr').length === 0) {
                                    // 如果没有广告位了，显示空提示
                                    $('tbody').html('<tr><td colspan="3" class="text-center">还没有添加广告位</td></tr>');
                                }
                            });
                            // 使用更友好的成功提示
                            main.showTip('success', response.msg || '广告位删除成功');
                        } else {
                            // 使用更友好的错误提示
                            main.showTip('error', response.msg || '删除失败，请稍后重试');
                        }
                    },
                    error: function(xhr) {
                        console.error('删除失败:', xhr.responseText);
                        main.showTip('error', '系统错误，请稍后重试');
                    }
                });
            }
        });
    </script>
@endsection
