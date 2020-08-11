<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';

    protected $guarded = [];

    public function clearance()
    {
        return $this->hasMany('clearance_data_analytics\Clearance');
    }

    public function deposit()
    {
        return $this->hasMany('clearance_data_analytics\Deposit');
    }
}
