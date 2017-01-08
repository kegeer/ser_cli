<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qc extends Model
{
    protected $fillable = ['run_id', 'summary', 'index', 'cycle', 'hist'];
    protected $casts = [
        'summary' => 'array',
        'index' => 'array',
        'cycle' => 'array',
        'hist' => 'array'
    ];
    public function setSummaryAttribute ($value)
    {
    	$this->attributes['summary'] = json_encode($value);
    }
    public function setIndexAttribute ($value)
    {
    	$this->attributes['index'] = json_encode($value);
    }
    public function setCycleAttribute ($value)
    {
    	$this->attributes['cycle'] = json_encode($value);
    }
    public function setHistAttribute ($value)
    {
    	$this->attributes['hist'] = json_encode($value);
    }
}
