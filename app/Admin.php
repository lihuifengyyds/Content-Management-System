<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin_user';
    public $fillable = ['username','password'];

    public function content()
    {
        return $this->hasMany('App\AdvContent','advid','id');
    }
}
