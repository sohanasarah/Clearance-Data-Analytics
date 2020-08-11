<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function clearance()
    {
        return $this->hasMany('clearance_data_analytics\Clearance');
    }

    public function brand(){
        return $this-> belongsTo('clearance_data_analytics\Brand');
    }
}
