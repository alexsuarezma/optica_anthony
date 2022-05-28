<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHasActivity extends Model
{
    use HasFactory;
    protected $table = 'orders_has_activity';

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function activity()
    {
        return $this->belongsTo('App\Models\Activity', 'activity_id');
    }
}
