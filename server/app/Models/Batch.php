<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['py_num', 'ori_num'];

    public function samples()
    {
    	return $this->hasMany('App\Models\Sample');
    }
}
