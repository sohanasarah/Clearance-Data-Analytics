<?php

namespace clearance_data_analytics\Http\Controllers\Charts;

use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use clearance_data_analytics\Segment;
use Illuminate\Support\Facades\DB;
use clearance_data_analytics\Calendar;
use clearance_data_analytics\Code;

class SegmentChartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $calendar_type       =  $request->get('calendar_type');
        $base_year           =  $request->get('base_year');
        $base_period_from     = $request->get('base_period_from');
        $base_period_to       = $request->get('base_period_to');
        $current_year         = $request->get('current_year');
        $current_period_from  = $request->get('current_period_from');
        $current_period_to    = $request->get('current_period_to');
        $measure             =  $request->get('measure');

        $base_data    = $this->get_segment_data($calendar_type, $base_year, $base_period_from, $base_period_to, $measure);
        $current_data = $this->get_segment_data($calendar_type, $current_year, $current_period_from, $current_period_to, $measure);

        /*for dropdown options*/
        $calendar = Calendar::select('*')
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        $codes = Code::select('id', 'code_value')
            ->where('field_name', 'measure')
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        return view('charts.SegmentCharts')
            ->with('base_data', $base_data)
            ->with('current_data', $current_data)
            ->with('calendar', $calendar)
            ->with('codes', $codes);
    }

    public function get_segment_data( $type, $year, $month_from, $month_to, $measure)
    {
        if($type == 'calendar_year'){
            $segments = Segment::select('internal_segment', DB::raw('SUM(figure) as total'))
            ->Join('brands', 'segments.id', 'brands.segment_id')
            ->Join('items', 'brands.id', 'items.brand_id')
            ->rightJoin('clearance', 'items.id', 'clearance.item_id')
            ->Join('calendar', 'clearance.calendar_id', 'calendar.id',)
            ->where('calendar.calendar_year', $year)
            ->whereBetween('calendar.calendar_period', [$month_from, $month_to])
            ->where('clearance.measure', $measure)
            ->groupBy('segments.internal_segment')
            ->get();
           
        }else{
            $segments = Segment::select('internal_segment', DB::raw('SUM(figure) as total'))
            ->Join('brands', 'segments.id', 'brands.segment_id')
            ->Join('items', 'brands.id', 'items.brand_id')
            ->rightJoin('clearance', 'items.id', 'clearance.item_id')
            ->Join('calendar', 'clearance.calendar_id', 'calendar.id',)
            ->where('calendar.fiscal_year', $year)
            ->whereBetween('calendar.fiscal_period', [$month_from, $month_to])
            ->where('clearance.measure', $measure)
            ->groupBy('segments.internal_segment')
            ->get();
        }

        $result[] = ['Segment', 'Total'];

        foreach ($segments as $key => $value) {
            $result[++$key] = [$value->internal_segment, (int) $value->total];
        }

        return json_encode(($result));
    }
}
