<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    protected $guarded = [];
    
    public function brand()
    {
        return $this->hasOne('clearance_data_analytics\Brand');
    }

}
