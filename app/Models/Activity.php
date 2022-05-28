<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    public function orders(){
        return $this->hasMany('App\Models\OrderHasActivity', 'activity_id');
    }

    public function detailActivity(){
        return $this->belongsTo('App\Models\DetailActivity', 'detail_activity_id');
    }    

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
