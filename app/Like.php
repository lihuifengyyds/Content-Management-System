<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    public $fillable = ['uid','cid'];

    public function content() 
    {
        return $this->belongsTo('App\Content','cid','id');
    }
}
