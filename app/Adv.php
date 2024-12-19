<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AdvContent;

class Adv extends Model
{
    protected $table = 'adv'; 
    public $fillable = ['name'];

    public function content()
    {
        return $this->hasMany(AdvContent::class, 'advid', 'id');
    }
}
