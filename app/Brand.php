<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];
    
    public function manufacturer(){
        return $this-> belongsTo('clearance_data_analytics\Manufacturer');
    }

    public function segment(){
        return $this-> belongsTo('clearance_data_analytics\Segment');
    }

    public function item()
    {
        return $this->hasMany('clearance_data_analytics\Item');
    }
}
