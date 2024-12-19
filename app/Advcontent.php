<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advcontent extends Model
{
    protected $table = 'advcontent'; 
    protected $fillable = ['advid', 'path'];

    public function setPathAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['path'] = '';
        } else if (is_array($value)) {
            $this->attributes['path'] = implode('|', array_filter($value));
        } else {
            $this->attributes['path'] = $value;
        }
    }

    public function getPathAttribute($value)
    {
        if (empty($value)) return [];
        return explode('|', $value);
    }

    public function position() 
    {
        return $this->belongsTo('App\Adv','advid','id');
    }
}
