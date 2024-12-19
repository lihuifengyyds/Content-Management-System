<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Content;

class ContentController extends Controller
{
    public function add()
    {
        $category = (new Category)->getTreeList();
        return view('admin.content.add',['category' => $category]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
    
        // Validate the input
        $this->validate($request, [
            'cid' => 'required',
            'title' => 'required',
        ], [
            'cid.required' => '栏目不能为空',
            'title.required' => '标题不能为空',
        ]);
    
        // Check if this is an update or create
        if (isset($data['id'])) {
            // Update existing content
            $content = Content::find($data['id']);
            if (!$content) {
                return redirect('content')->with('error', '内容不存在');
            }
            $re = $content->update($data);
            $message = '更新成功';
        } else {
            // Create new content
            $re = Content::create($data);
            $message = '添加成功';
        }
    
        if ($re) {
            return redirect('content')->with('success', $message);
        } else {
            return back()->with('error', isset($data['id']) ? '更新失败' : '添加失败');
        }
    }
    
    public function upload(Request $request)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');
            if($image->isValid()){
                $name = md5(microtime(true)) . '.' . $image->extension();
                $image->move('static/upload/',$name);
                $path = '/static/upload/' .$name;
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

    public function index($cid = 0)
    {
        $category = (new Category)->getTreeList();
        $content = Content::get(); 
        if($cid){
            $content = Content::where('cid',$cid)->get();
        }
        return view('admin.content.index',['category' => $category,'content' => $content,'cid' => $cid]);
    }

    public function category()
    {
        return $this->belongsTo('App\Category','cid','id');
    }

    public function edit($id)
    {
        $category = (new Category)->getTreeList();
        $content = Content::find($id);
        if (!$content) {
            return redirect('content')->with('error', '内容不存在');
        }
        return view('admin.content.edit', ['category' => $category, 'content' => $content]);
    }

    public function delete($id)
    {
        if(!$content = Content::find($id)){
            return response()->json(['code' => 0, 'msg' => '删除失败，记录不存在']);
        }
        $content->delete();  // 修正了这一行
        return response()->json(['code' => 1, 'msg' => '删除成功']);
    }
}
