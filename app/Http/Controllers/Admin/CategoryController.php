<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function add()
    {
        $category = Category::where('pid', 0)->get();
        return view('admin.category.add', ['category' => $category]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $rule = isset($data['id']) ? ',name,' . $data['id'] : '';
        $this->validate($request, [
            'name' => 'required|unique:category' . $rule,
        ], [
            'name.require' => '栏目名称不能为空',
            'name.unique' => '栏目名称不能重复'
        ]);
        if (isset($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            unset($data['_token']);
            $res = Category::where('id', $id)->update($data);
            $type = $res ? 'message' : 'tip';
            $message = $res ? '修改成功' : '修改失败';
            return redirect('category')->with($type, $message);
        }
        $re = Category::create($data);
         if($re) {
             return redirect('category')->with('message','添加成功');
         }else{
             return redirect('category/add')->with('tip','添加失败');
         }
    }

    /**
     * 删除栏目
     */
    public function delete($id)
    {
        try {
            // 查找栏目
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['code' => 0, 'msg' => '栏目不存在']);
            }

            // 检查是否有子栏目
            $hasChildren = Category::where('pid', $id)->exists();
            if ($hasChildren) {
                return response()->json(['code' => 0, 'msg' => '请先删除该栏目下的所有子栏目']);
            }

            // 检查是否有关联的内容
            $hasContent = DB::table('content')->where('cid', $id)->exists();
            if ($hasContent) {
                return response()->json(['code' => 0, 'msg' => '请先删除该栏目下的所有内容']);
            }

            // 删除栏目
            $category->delete();

            return response()->json(['code' => 1, 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return response()->json(['code' => 0, 'msg' => '删除失败：' . $e->getMessage()]);
        }
    }
    public function index()
    {
        $category = (new Category)->getTreeList();
        // dd($category);
        return view('admin.category.index', ['category' => $category]);
    }

    public function sort(Request $request)
    {
        // 验证输入数据
        $this->validate($request, [
            'sort' => 'required|array',
            'sort.*' => 'required|integer|min:0'
        ], [
            'sort.required' => '排序数据不能为空',
            'sort.array' => '排序数据格式错误',
            'sort.*.integer' => '排序值必须为整数',
            'sort.*.min' => '排序值不能为负数'
        ]);

        try {
            $sort = $request->input('sort');
            $updates = [];

            foreach ($sort as $id => $value) {
                $updates[] = [
                    'id' => (int)$id,
                    'sort' => (int)$value
                ];
            }

            // 批量更新提高效率
            Category::upsert($updates, ['id'], ['sort']);

            return redirect('category')->with('message', '排序更新成功');
        } catch (\Exception $e) {
            return redirect('category')->with('error', '排序更新失败：' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = [];
        if ($id) {
            if (!$data = Category::find($id)) {
                return back()->with('tip', '记录不存在.');
            }
        }
        $category = Category::where('pid', 0)->get();
        return view('admin.category.edit', ['id' => $id, 'data' => $data, 'category' => $category]);
    }
}
