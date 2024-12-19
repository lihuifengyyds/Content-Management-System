@extends('admin/layouts/admin')
@section('title', '添加内容')
@section('main')
    <link rel="stylesheet" href="{{ asset('admin') }}/common/uploader/uploadifive.css">
    {{-- 首先加载 jQuery --}}
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    {{-- 然后再加载其他依赖 jQuery 的插件 --}}
    <script src="{{ asset('admin') }}/common/uploader/jquery.uploadifive.min.js"></script>
    <script src="{{ asset('admin') }}/common/uploader/jquery.uploadifive.js"></script>
    <script src="{{ asset('admin') }}/common/editor/ueditor1.4.3.3/ueditor.config.js"></script>
    <script src="{{ asset('admin') }}/common/editor/ueditor1.4.3.3/ueditor.all.min.js"></script>
    <script src="{{ asset('admin') }}/common/editor/main.editor.js"></script>
    <div class="main-title">
        <h2>添加内容</h2>
    </div>
    <div class="main-section">
        <div style="width: 543px">
            {{-- 添加内容表单 --}}
            <form action="{{ url('content/save') }}" class="j-form" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">所属栏目</label>
                    <div class="col-sm-10">
                        <select name="cid" id="" class="form-control" style="width:200px;">
                            {{-- 栏目下拉列表 --}}
                            <option value="0">---</option>
                            @foreach ($category as $v)
                                <option value="{{ $v['id'] }}">
                                    @if ($v['level'])
                                        |---
                                    @endif {{ $v['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" style="width:200px;">
                    </div>
                </div>
                {{-- 上传图片按钮 --}}
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">图片</label>
                    <div class="col-sm-10">
                        <input type="file" id="file1" name="image" style="width:200px;" multiple="true">
                        <div class="upload-img-box" id="uploadImg"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">简介</label>
                    <div class="col-sm-10">
                        <textarea name="content" class="j-content" style="height:500px;"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">状态</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline" style="height:38px;">
                            <input type="radio" class="form-check-input" id="inlineRadio1" name="status" value="1"
                                checked>
                            <label for="inlineRadio1" class="form-check-label">默认</label>
                        </div>
                        <div class="form-check form-check-inline" style="height:38px">
                            <input type="radio" name="status" id="inlineRadio2" class="form-check-input" value="2">
                            <label for="inlineRadio2" class="form-check-label">推荐</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary mt-2">提交表单</button>
                        <a href="{{ url('/content') }}" class="btn btn-secondary">返回列表</a>
                    </div>
                </div>
            </form>
            <script>
                main.menuActive('addarticle');

                main.editor($('.j-content'), 'content_edit', function() {
                    window.UEDITOR_HOME_URL = '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/';
                    // 基础路径配置
                    window.UEDITOR_CONFIG.themePath = '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/themes/';
                    window.UEDITOR_CONFIG.cssPath =
                        '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/themes/default/css/ueditor.css';
                    window.UEDITOR_CONFIG.langPath = '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/lang/';
                    window.UEDITOR_CONFIG.iframeCssUrl =
                        '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/themes/iframe.css';
                    // CodeMirror 相关配置
                    window.UEDITOR_CONFIG.codeMirrorJsUrl =
                        '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/third-party/codemirror/codemirror.js';
                    window.UEDITOR_CONFIG.codeMirrorCssUrl =
                        '{{ asset('admin') }}/common/editor/ueditor1.4.3.3/third-party/codemirror/codemirror.css';
                    // ZeroClipboard 配置
                    window.UEDITOR_CONFIG.zIndex = 900;
                    window.UEDITOR_CONFIG.UEDITOR_HOME_URL = window.UEDITOR_HOME_URL;
                }, function(editor) {
                    $('.j-form').submit(function() {
                        editor.sync();
                    });

                });

                $(function() {
                    $('#file1').uploadifive({
                        'auto': true,
                        'fileObjName': 'image',
                        'fileType': 'image',
                        'buttonText': '上传图片',
                        'formData': {
                            _token: '{{ csrf_token() }}'
                        },
                        'method': 'post',
                        'queueID': 'uploadImg',
                        'removeCompleted': true,
                        'uploadScript': '{{ url('content/upload') }}',
                        'onUploadComplete': uploadPicture
                    });
                });

                function uploadPicture(file, data) {
                    var obj = $.parseJSON(data);
                    var src = "";
                    if (obj.code) {
                        filename = obj.data.filename;
                        path = obj.data.path;
                        $('.upload-img-box').html('<div class="upload-pre-item" style="max-height:100%;"><img src="' + path +
                            '" style="width:100px;height:100px"><input type="hidden" name="image" value="' + filename +
                            '" class="icon_banner"></div>');
                    } else {
                        alert(data.info);
                    }
                }
            </script>
        @endsection
