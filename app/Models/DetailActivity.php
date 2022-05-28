<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailActivity extends Model
{
    use HasFactory;
    protected $table = 'detail_activities';

    public function state(){
        return $this->belongsTo('App\Models\State', 'state_id');
    }
}
