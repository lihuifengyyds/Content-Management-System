@extends('admin/layouts/admin')
@section('title', '添加广告')
@section('main')
    <link rel="stylesheet" href="{{ asset('admin') }}/common/uploader/uploadifive.css">
    <script src="{{ asset('admin') }}/common/uploader/jquery.uploadifive.js"></script>
    <div class="main-title">
        <h2>@if(!empty($data)) 编辑 @else 添加 @endif 广告</h2>
    </div>
    <div style="width:543px">
        <form action="{{ url('/advcontent/save') }}" method="POST">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">选择广告</label>
                <div class="col-sm-9">
                    {{-- 广告位列表 --}}
                    <select name="advid" id="form-control" style="width:200px;">
                        @foreach ($position as $v)
                            <option value="{{ $v->id }}" @if (isset($data['advid']) && $data['advid'] == $v['id']) selected @endif>
                                {{ $v->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">上传图片</label>
                <div class="col-sm-9">
                    <input type="file" name="path" id="file1" value="上传图片">
                    <div class="upload-img-box" id="uploadImg">
                        @if(isset($data->path))
                        <div class="upload-pre-item" style="max-height:100%;">
                            @foreach($data->path as $val)
                                <div class="img-item" style="display:inline-block;position:relative;margin:5px;">
                                    <img src="/static/upload/{{$val}}" style="height:100px;width:100px">
                                    <input type="hidden" name="path[]" value="{{$val}}" class="icon_banner">
                                    <span class="delete-img" onclick="deleteImage(this)" style="position:absolute;top:0;right:0;background:red;color:white;cursor:pointer;padding:2px 5px;">×</span>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-9">
                    {{ csrf_field() }}
                    @if(isset($data['id'])) 
                        <input type="hidden" name="id" value="{{$data->id}}">
                    @endif
                    <button type="submit" class="btn btn-primary mr-2">提交表单</button>
                    <a href="{{ url('advcontent') }}" class="btn btn-secondary">返回列表</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        main.menuActive('addcategory');
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
                'uploadScript': '{{ url('advcontent/upload') }}',
                'onUploadComplete': uploadPicture
            });
        });

        function uploadPicture(file, data) {
            var obj = $.parseJSON(data);
            if (obj.code) {
                var filename = obj.data.filename;
                var path = obj.data.path;

                // 检查返回数据
                console.log('Upload response:', obj);

                // 追加新图片到现有图片后面
                if ($('.upload-pre-item').length > 0) {
                    // 已经有图片，追加到现有的容器中
                    $('.upload-pre-item').append(
                        '<div class="img-item" style="display:inline-block;position:relative;margin:5px;">' +
                        '<img src="' + path + '" style="width:100px;height:100px"/>' +
                        '<input type="hidden" name="path[]" value="' + filename + '" class="icon_banner">' +
                        '<span class="delete-img" onclick="deleteImage(this)" style="position:absolute;top:0;right:0;background:red;color:white;cursor:pointer;padding:2px 5px;">×</span>' +
                        '</div>'
                    );
                } else {
                    // 没有图片，创建新容器
                    $('#uploadImg').html(
                        '<div class="upload-pre-item" style="max-height:100%;">' +
                        '<div class="img-item" style="display:inline-block;position:relative;margin:5px;">' +
                        '<img src="' + path + '" style="width:100px;height:100px"/>' +
                        '<input type="hidden" name="path[]" value="' + filename + '" class="icon_banner">' +
                        '<span class="delete-img" onclick="deleteImage(this)" style="position:absolute;top:0;right:0;background:red;color:white;cursor:pointer;padding:2px 5px;">×</span>' +
                        '</div>' +
                        '</div>'
                    );
                }
            } else {
                alert(obj.info || '上传失败');
            }
        }

        function deleteImage(element) {
            $(element).closest('.img-item').remove();
            // 如果没有图片了，移除容器
            if ($('.img-item').length === 0) {
                $('.upload-pre-item').remove();
            }
        }
    </script>
@endsection
