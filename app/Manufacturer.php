<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $guarded = [];
    
    public function brand()
    {
        return $this->hasOne('clearance_data_analytics\Brand');
    }

    public function deposit()
    {
        return $this->hasMany('clearance_data_analytics\Deposit');
    }

}
