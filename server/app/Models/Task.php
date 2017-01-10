<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = ['name', 'pushed', 'project_id', 'pipeline_id', 'start_time', 'end_time', 'exp_manager', 'info_manager'];

    public function samples ()
    {
    	return $this->morphToMany('App\Models\Sample', 'samplable');
    }
    public function setStartTimeAttribute ($value)
    {
        $this->attributes['start_time'] = Carbon::parse($value)->format('Y-m-d');
    }
    public function setEndTimeAttribute ($value)
    {
        $this->attributes['end_time'] = Carbon::parse($value)->format('Y-m-d');
    }
    public function batches ()
    {
        return $this->hasMany('App\Models\Batch');
    }
}
