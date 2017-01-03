<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = ['batch_id', 'ori_num', 'py_num', 'sample_amount_type', 'sample_amount', 'sample_status'];
    public function tasks ()
    {
    	return $this->morphByMany('App\Models\Tasks', 'samplable');
    }
}
