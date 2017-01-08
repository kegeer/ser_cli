<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    protected $fillabel = ['client_id', 'name', 'gender', 'age', 'height', 'weight', 'waistline', 'phone', 'disease', 'disease_history'];
}
