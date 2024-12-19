<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Adv;
use App\Advcontent;

class AdvController extends Controller
{
    public function add($id = 0)
    {
        $data = [];
        if ($id > 0) {
            $data = Adv::find($id);
        }
        return view('admin.adv.add', ['data' => $data]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required'
        ], [
            'name.required' => '广告位名称不能为空'
        ]);

        if (isset($data['id'])) {
            // 更新现有记录
            $id = $data['id'];
            unset($data['id']);
            $res = Adv::where('id', $id)->update($data);
            $type = $res ? 'message' : 'tip';
            $message = $res ? '修改成功' : '修改失败';
            return redirect('adv')->with($type, $message);
        } else {
            // 创建新记录
            $re = Adv::create($data);
            if ($re) {
                return redirect('adv')->with('message', '添加成功');
            } else {
                return redirect('adv/add')->with('tip', '添加失败');
            }
        }
    }

    public function index()
    {
        $adv = Adv::all();
        return view('admin.adv.index', ['adv' => $adv]);
    }

    /**
     * 删除广告位
     */
    public function delete($id)
    {
        try {
            // 查找广告位
            $adv = Adv::find($id);
            if (!$adv) {
                return response()->json(['status' => 0, 'msg' => '广告位不存在']);
            }

            // 检查是否有关联的广告内容
            $hasContent = Advcontent::where('advid', $id)->exists();
            if ($hasContent) {
                return response()->json(['status' => 0, 'msg' => '请先删除该广告位下的所有广告内容']);
            }

            // 删除广告位
            $adv->delete();

            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'msg' => '删除失败：' . $e->getMessage()]);
        }
    }
}
