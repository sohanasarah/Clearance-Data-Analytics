<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $guarded = [];

    public function calendar()
    {
        return $this->belongsTo('clearance_data_analytics\Calendar');
    }

    public function manufacturer()
    {
        return $this->belongsTo('clearance_data_analytics\Manufacturer');
    }
}
