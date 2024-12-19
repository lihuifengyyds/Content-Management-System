<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Adv;
use App\Advcontent;

class AdvcontentController extends Controller
{
    public function add($id = 0)
    {
        $position = Adv::all();
        $data = [];
        if ($id > 0) {
            $data = Advcontent::find($id);
            // 不需要在这里处理 path，因为模型会自动处理
        }
        return View('admin.advcontent.add', ['data' => $data, 'position' => $position]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $name = md5(microtime(true)) . '.' . $image->extension();
                $image->move('static/upload/', $name);
                $path = '/static/upload/' . $name;
                $return_data = array(
                    'filename' => $name,
                    'path' => $path
                );
                $result = [
                    'code' => 1,
                    'msg' => '上传成功',
                    'time' => time(),
                    'data' => $return_data,
                ];
                return response()->json($result);
            }
            return $image->getErrorMessage();
        }
        return '文件上传成功';
    }

    public function save(Request $request)
    {
        $data = $request->all();
        
        // 验证必填字段
        $this->validate($request, [
            'advid' => 'required',
        ], [
            'advid.required' => '请选择广告位',
        ]);

        if (isset($data['id'])) {
            // 更新
            $advcontent = Advcontent::find($data['id']);
            if (!$advcontent) {
                return redirect('advcontent')->with('error', '广告内容不存在');
            }
            unset($data['_token']);
            $res = $advcontent->update($data);
            return redirect('advcontent')->with($res ? 'success' : 'error', $res ? '修改成功' : '修改失败');
        } else {
            // 新增
            $res = Advcontent::create($data);
            return redirect('advcontent')->with($res ? 'success' : 'error', $res ? '添加成功' : '添加失败');
        }
    }

    public function index()
    {
        $adv = Advcontent::all();
        return view('admin.advcontent.index', ['adv' => $adv]);
    }

    /**
     * 删除广告内容
     */
    public function delete($id)
    {
        try {
            $advcontent = Advcontent::find($id);
            if (!$advcontent) {
                return response()->json(['status' => 0, 'msg' => '广告内容不存在']);
            }

            // 删除记录
            $advcontent->delete();
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'msg' => '删除失败：' . $e->getMessage()]);
        }
    }
}
