@extends('admin.layouts.admin')
@section('title','后台首页') 
@section('main') 
<div>
    <div class="main-title">
        <h2>首页</h2>
    </div>
    <div class="main-section">
        <div class="card">
            <div class="card-header">服务器信息</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">系统环境；{{ $server_version}}</li>
                <li class="list-group-item">Laravel版本；{{ $laravel_version}}</li>
                <li class="list-group-item">MySQL版本；{{ $mysql_version}}</li>
                <li class="list-group-item">服务器时间；{{ $server_time}}</li>
                <li class="list-group-item">文件上传限制：{{ $upload_max_filesize}}</li>
                <li class="list-group-item">脚本执行时限：{{ $max_execution_time}}</li>
            </ul>
        </div>
    </div>
</div>
@endsection