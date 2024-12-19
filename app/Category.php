<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Category extends Model
{
    protected $table = 'category';
    public $fillable = ['pid','name','sort'];

    public function getTreeList() 
    {
        $data = $this->orderBy('sort','asc')->get()->toArray(); 
        return $this->getTreeListCheckLeaf($data); 
    }

    public function getTreeListCheckLeaf($data, $name = 'isLeaf') 
    {
        $pidMap = [];
        foreach ($data as $item) {
            if (!isset($pidMap[$item['pid']])) {
                $pidMap[$item['pid']] = [];
            }
            $pidMap[$item['pid']][] = $item['id'];
        }

        $data = $this->treeList($data); 
        foreach ($data as $k => $v) {
            $data[$k][$name] = !isset($pidMap[$v['id']]) || empty($pidMap[$v['id']]);
        }
        return $data;
    }

    public function treeList($data, $pid = 0, $level = 0, &$tree = [])
    {
        if (!is_array($data) || !is_array($tree)) {
            return [];
        }
        
        foreach($data as $v){
            if($v['pid'] === $pid){
                $v['level'] = $level; 
                $tree[] = $v; 
                $this->treeList($data, $v['id'],$level +1, $tree);
            }
        }
        return $tree;
    }

    public function content() 
    {
        return $this->hasMany('App\Content','cid','id')->orderBy('id','desc')->limit(1);
    }


}
