<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = ['batch_id', 'ori_num', 'py_num'];
    public function tasks ()
    {
    	return $this->hasMany('App/Models/Task');
    }
}
