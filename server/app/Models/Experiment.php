<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    protected $fillable = ['sample_id', 'current_step', 'current_step_id', 'status', 'quality'];
    protected $casts = [
    	'quality' => 'array'
    ];

    public function setQualityAttribute ($value)
    {
    	$this->attributes['quality'] = json_encode($value);
    }
}
