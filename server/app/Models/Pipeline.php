<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    protected $fillable = ['name', 'steps'];
    public function setStepsAttribute ($value)
    {
    	$this->attributes['steps'] = json_encode($value);
    }
}
