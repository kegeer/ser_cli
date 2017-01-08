<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Batch extends Model
{
    protected $fillable = ['client_id', 'samples_type', 'sender', 'sender_contact', 'send_time', 'arrive_status', 'store_location', 'arrive_time', 'recipients', 'express_num', 'note'];
    // protected $dates = ['send_time', 'arrive_time'];
    public function samples()
    {
    	return $this->hasMany('App\Models\Sample');
    }
    public function setSendTimeAttribute ($value)
    {
         // $this->attributes['send_time'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        $this->attributes['send_time'] = Carbon::parse($value)->format('Y-m-d');
    }
    public function setArriveTimeAttribute ($value)
    {
        // $this->attributes['arrive_time'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
    	$this->attributes['arrive_time'] = Carbon::parse($value)->format('Y-m-d');
    }
    public function task ()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
