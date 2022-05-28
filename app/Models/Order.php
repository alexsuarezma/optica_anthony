<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $casts = [
        'data' => 'array',
    ];

    public function activities(){
        return $this->hasMany('App\Models\OrderHasActivity', 'order_id');
    }

    public function state(){
        return $this->belongsTo('App\Models\State', 'state_id');
    }
}
