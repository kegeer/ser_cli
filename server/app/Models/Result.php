<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['sample_id', 'product', 'major', 'sub', 'revision', 'result'];
    protected $casts = [
    	'result' => 'array'
    ];
    public function setResultAttribute ($value)
    {
    	$this->attributes['result'] = json_encode($value);
    }
}
