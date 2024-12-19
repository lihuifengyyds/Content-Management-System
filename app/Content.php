<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = "content";

    public $fillable = ['cid','title','content','image','status'];

    public function category()
    {
        return $this->belongsTo('App\Category','cid','id');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment','cid','id');
    }

}
