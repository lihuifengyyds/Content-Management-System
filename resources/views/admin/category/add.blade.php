@extends('admin/layouts/admin')
@section('title', '添加项目')
@section('main')
    <div class="main-title">
        <h2>添加栏目</h2>
    </div>
    <div class="main-section">
        <div style="width:543px">
            {{-- 添加栏目表单 --}}
            <form action="{{ url('/category/save') }}" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">序号</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="sort" value="0" style="width:80px;">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">上级目录</label>
                    <div class="col-sm-10">
                        <select name="pid" class="form-control" style="width:200px;">
                            <option value="0">---</option>
                            @foreach ($category as $v)
                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" style="width:200px;">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        {{csrf_field()}} 
                        <button type="submit" class="btn btn-primary mr-2">提交表单</button>
                        <a href="{{url('category')}}" class="btn btn-secondary">返回列表</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        main.menuActive('addcategory');
    </script>
@endsection
