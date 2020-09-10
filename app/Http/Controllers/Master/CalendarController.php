<?php

namespace clearance_data_analytics\Http\Controllers\Master;

use clearance_data_analytics\Calendar;
use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use clearance_data_analytics\Manufacturer;
use clearance_data_analytics\Segment;
use Illuminate\Support\Facades\Validator;
class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendar = Calendar::orderBy('id')->get();

        return view('master.calendar.index')->with('calendar', $calendar);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        //Validate the Data
        $validatedData = Validator::make($request->all(), [
            'year' => 'required|numeric',
            'period' => 'required|numeric',
            'fiscal_year' => 'required|string',
            'fiscal_period' => 'required|numeric',
            'month_name'  => 'required|string',
            'expired'  => 'required|string',
            'status'  => 'required|string'
        ]);

        if ($validatedData->fails()) {
            return response()->json(
                [
                    'success' => 'false',
                    'errors' => $validatedData->errors()->all(),
                ],
                400
            );
        } else {
            try {
                // $data = new Calendar();
                // $data->calendar_year =   request('year');
                // $data->calendar_period = request('period');
                // $data->month_name =  request('month_name');
                // $data->fiscal_year = request('fiscal_year');
                // $data->fiscal_period = request('fiscal_period');
                // $data->expired = request('expired');
                // $data->status = request('status');
                // $data->save();

                $data = Calendar::updateOrCreate(
                    ['id' => $request->calendar_id],
                    [
                        'calendar_year'  => $request->year,
                        'calendar_period'=> $request->period,
                        'fiscal_year'   => $request->fiscal_year,
                        'fiscal_period' => $request->fiscal_period,
                        'month_name'    => $request->month_name,
                        'expired'       => $request->expired,
                        'status'        => $request->status
                    ]
                );

                error_log($data);
                
                return response()->json(
                    [
                        'success' => 'true',
                        'message' => 'Data inserted successfully!'
                    ]
                );
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(
                    [
                        'success' => false,
                        'errors' => $th->getMessage(),
                    ],
                    400
                );
            }
        }
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calendar = Calendar::find($id);
        return response()->json($calendar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Calendar::find($id)->delete();
        return response()->json(['success' => 'true','message'=>'Calendar Record Has Been Deleted!']);
    }
}
