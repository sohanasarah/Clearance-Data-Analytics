<?php

namespace clearance_data_analytics;

use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    protected $table = 'clearance';

    public $fillable = ['calendar_id', 'item_id', 'measure', 'figure'];

    protected $guarded = ['id'];

    public function calendar()
    {
        return $this->belongsTo('clearance_data_analytics\Calendar', 'calendar_id');
    }

    public function item()
    {
        return $this->belongsTo('clearance_data_analytics\Item', 'item_id');
    }

}
