<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\AdvContent;
use App\AdvPosition;
use App\Content;
use App\Adv;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index()
    {
        // 获取分类数据
        $this->navBar(); 
        $this->hotContent();
        $recommend = Content::where('status',1)->get();
        
        // 获取广告数据 - 获取所有广告内容
        $advcontent = [];
        $advlist = Adv::all();  // 获取所有广告位
        foreach ($advlist as $adv) {
            if ($adv->content) {
                foreach ($adv->content as $v) {
                    if (!empty($v->path) && is_array($v->path)) {
                        // 只使用第一张图片作为广告图
                        $advcontent[] = [
                            'image' => $v->path[0],  // 取数组的第一个元素
                            'url' => '#'  // 如果需要链接，可以从数据库中获取
                        ];
                    }
                }
            }
        }
        
        $list = Category::orderBy('id','desc')->get()->take(4); 
        return view('index',['recommend'=>$recommend,'adv' => $advcontent,'list' => $list]);
    }

    protected function navBar()
    {
        $data = Category::orderBy('sort','asc')->get()->toArray(); 
        $category = $sub = []; 
        foreach ($data as $k => $v){
            if($v['pid'] != 0){
                $sub[$v['pid']] = $v;
            }
        }
        foreach ($data as $key => $val){
            if($val['pid'] == 0){
                $category[$key] = $val; 
            }
            foreach ($sub as $subv){
                if($subv['pid'] == $val['id']){
                    $category[$key]['sub'][] = $subv;
                }
            }
        }
        return view()->share('category',$category);
    }

    public function content() 
    {
        return $this->hasMany(AdvContent::class, 'advid', 'id');
    }

    public function lists($id)
    {
        if(!$id){
            return redirect('/')->with('tip','缺少参数');
        }
        $this->navBar();
        $this->hotContent();
        $content = Content::where('cid',$id)->paginate(4);
        return view('lists',['content'=>$content,'id'=>$id]);
    }

    public function detail($id)
    {
        if(!$id){
            return redirect('/')->with('tip','缺少参数');
        }
        $this->navBar(); 
        $this->hotContent();
        $content = Content::find($id); 
        $count = Like::where('cid',$id)->get()->count();
        $comments = Comment::where('cid',$id)->get();
        return view('detail',['id' => $content->id,'cid' => $content->cid,'content' => $content,'count' => $count,'comments' => $comments]);
    }

     public function like($id)
     {
         if (!$id) {
             return response()->json(['status' => '2', 'msg' => '缺少参数']);
         }
     
         $uid = session()->get('users.id');
         if (!$uid) {
             return response()->json(['status' => '2', 'msg' => '请先登录']);
         }
     
         $existLike = Like::where('uid', $uid)
                          ->where('cid', $id)
                          ->first();
     
         if ($existLike) {
             return response()->json([
                 'status' => '2', 
                 'msg' => '您已经点过赞了'
             ]);
         }
     
         $data = [
             'uid' => $uid,
             'cid' => $id
         ];
     
         $re = Like::create($data);
     
         if ($re) {
             $count = Like::where('cid', $id)->count();
             return response()->json([
                 'status' => '1',
                 'msg' => '点赞成功',
                 'count' => $count
             ]);
         } else {
             return response()->json([
                 'status' => '2',
                 'msg' => '点赞失败'
             ]);
         }
     }

     public function comment(Request $request)
     {
        $cid = $request->input('cid');
        $content = $request->input('content');
        $uid = session()->get('users.id'); 
        if(!$content){
            return response()->json(['status' => '2','msg' => '缺少参数']);
        }
        $data = [
            'uid' => $uid, 
            'cid' => $cid,
            'content' => $content,
        ];
        $re = Comment::create($data);
        if($re){
            $theComment = Comment::where('cid',$cid)->where('uid',$uid)->orderBy('id','desc')->first();
            $theComment->created_time = date('Y-m-d',strtotime($theComment->created_at));
            $count = Comment::where('cid',$cid)->get()->count(); 
            $theComment->count = $count;  
            $theComment->user = $theComment->user->name;
            return response()->json(['status' =>'1','msg' => '评论成功','data' => $theComment]);
        } else {
            return response()->json(['status' => '2','msg' => '评论失败']);
        }
     }

     protected function hotContent()
     {
        // 获取点赞数据并关联文章内容
        $hotContent = Content::select('content.*', DB::raw('COUNT(likes.id) as like_count'))
            ->leftJoin('likes', 'content.id', '=', 'likes.cid')
            ->where('content.status', 1)  // 只获取已发布的文章
            ->groupBy('content.id')
            ->having('like_count', '>', 0)  // 只获取有点赞的文章
            ->orderBy('like_count', 'desc')  // 按点赞数降序排序
            ->take(5)  // 获取前5篇文章
            ->get();

        return view()->share('hotContent', $hotContent);
     }
}
