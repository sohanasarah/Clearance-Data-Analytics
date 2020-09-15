<?php

namespace clearance_data_analytics\Http\Controllers\Master;

use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use clearance_data_analytics\Clearance;
use clearance_data_analytics\Calendar;
use clearance_data_analytics\Item;
use clearance_data_analytics\Code;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use clearance_data_analytics\Imports\ClearanceImport;

class ClearanceController extends Controller
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
        /* Clearance table joining Calendar, Item tables (one to many relationship). Configuration done in Models */
        $clearance = Clearance::with('calendar', 'item')->orderBy('id', 'desc')->get();

        /* for dropdown options */
        $items = Item::select('id', 'item_code', 'item_name')
            ->where('status', 'active')
            ->orderBy('id')
            ->get();
        
        $codes = Code::select('id', 'code_value', 'comments')
         ->where('field_name','measure')
         ->where('status', 'active')
         ->orderBy('id')
         ->get();

        $calendar = Calendar::select('calendar_year', 'calendar_period')
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        return view('master.clearance.index')->with('clearance', $clearance)
            ->with('items', $items)
            ->with('codes', $codes)
            ->with('calendar', $calendar);
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
            'month' => 'required|numeric',
            'item_id' => 'required|numeric',
            'figure' => 'required|numeric',
            'measure'  => 'required|max:48'
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
                $calendar_data = Calendar::where('calendar_year', request('year'))
                    ->Where('calendar_period', request('month'))
                    ->first();

                $data = Clearance::updateOrCreate(
                    ['id' => $request->clearance_id],
                    [
                        'calendar_id'  => $calendar_data->id,
                        'item_id' => $request->item_id,
                        'measure' => $request->measure,
                        'figure'  => $request->figure
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clearance = Clearance::with('calendar')->find($id);
        return response()->json($clearance);
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
        Clearance::find($id)->delete();

        return response()->json(['success' => 'true', 'message' => 'Clearance Has Been Deleted!']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function import(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'import_file' => 'required|mimes:csv,txt'
        ]);

        if ($validatedData->fails()) {
            return response()->json(
                ['message' => $validatedData->errors()->all()],
                400
            );
        } else {
            try {
                Excel::import(new ClearanceImport, request()->file('import_file'));
            } catch (ValidationException $e) {
                //dd($e);
                $failures = $e->failures();
                $jsonOutput = [];

                foreach ($failures as $failure) {
                    $jsonOutput[$failure->attribute()] = $failure->errors();
                }
                return response()->json(['message' => $jsonOutput], 400);
            }
            return response()->json(['success' => 'File Uploaded Successfully!']);
        }
    }
}
