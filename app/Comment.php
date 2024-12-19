<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['uid','cid','content'];

    public function user()
    {
        return $this->belongsTo('App\User','uid','id');
    }
}
