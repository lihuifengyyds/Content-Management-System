@extends('admin/layouts/admin')
@section('title', '栏目列表')
@section('main')
    <div class="main-title">
        <h2>栏目管理</h2>
    </div>
    <div class="main-section form-inline">
        <a href="{{ url('category/add') }}" class="btn btn-success">+ 新增</a>
    </div>
    <div class="main-section">
        <form action="{{ url('category/sort') }}" class="j-form" method="POST">
            {{-- {{ csrf_field() }} --}}
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="75">序号</th>
                        <th>名称</th>
                        <th width="100">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($category))
                        <tr>
                            <td colspan="3" class="text-center">没有添加栏目</td>
                        </tr>
                    @endif
                </tbody>

                @foreach ($category as $v)
                    <tr class="j-pid-{{ $v['pid'] }}" @if ($v['level']) style="display:none" @endif>
                        <td><input type="text" class="form-control j-sort" maxlength="5" value="{{ $v['sort'] }}"
                                data-name="sort[{{ $v['id'] }}]" style="height:25px;font-size:12px;padding:0 5px;">
                        </td>
                        <td>
                            @if ($v['level'])
                                <small class="text-muted">|---</small>{{ $v['name'] }}
                            @else
                                <a href="#" class="j-toggle" data-id="{{ $v['id'] }}">
                                    @if (!$v['isLeaf'])
                                        <i class="fa fa-plus-square-o fa-fw"></i>
                                    @endif
                                    {{ $v['name'] }}
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('category/edit', ['id' => $v['id']]) }}" style="margin-right:5px;">编辑</a>
                            <a href="{{ url('category/delete', ['id' => $v['id']]) }}" class="j-del text-danger">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ csrf_field() }}
            <input type="submit" value="改变排序" class="btn btn-primary">
        </form>
    </div>
@endsection

{{-- <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script> --}}
<script>
    main.menuActive('category');
    $(document).ready(function() {
        $('.j-sort').change(function() {
            $(this).attr('name', $(this).attr('data-name'));
        });

        $('.j-del').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var $row = $this.closest('tr');
            var categoryName = $row.find('td:nth-child(2)').text().trim();
            
            if (confirm('您确定要删除"' + categoryName + '"栏目吗？删除后不可恢复！')) {
                $.ajax({
                    url: $this.attr('href'),
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.code === 1) {
                            alert(response.msg);
                            // 删除成功后移除该行
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                // 检查是否还有其他栏目
                                if ($('tbody tr').length === 0) {
                                    // 如果没有栏目了，显示空提示
                                    $('tbody').html('<tr><td colspan="3" class="text-center">没有添加栏目</td></tr>');
                                }
                            });
                        } else {
                            alert(response.msg || '删除失败');
                        }
                    },
                    error: function(xhr) {
                        console.error('删除失败:', xhr.responseText);
                        alert('系统错误，请稍后重试');
                    }
                });
            }
        });

        // 切换子栏目显示/隐藏
        $('.j-toggle').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('.j-pid-' + id).toggle();
            $(this).find('i').toggleClass('fa-plus-square-o fa-minus-square-o');
        });
    });
</script>
