<?php

namespace clearance_data_analytics\Http\Controllers\Master;


use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use clearance_data_analytics\Manufacturer;
use clearance_data_analytics\Deposit;
use clearance_data_analytics\Calendar;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use clearance_data_analytics\Imports\DepositImport;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
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

        /* Deposit table joining Calendar, Manufacture tables (one to many relationship). Configuration done in Models */
        $deposits = Deposit::with('calendar', 'manufacturer')->orderBy('id', 'asc')->get();

        /* for dropdown options */
        $manufacturers = Manufacturer::where('status', 'active')->orderBy('id')->get(['id', 'short_name']);
        $calendar = Calendar::where('status', 'active')->orderBy('id')->get(['calendar_year', 'calendar_period']);

        return view('master.deposits.index')->with('deposits', $deposits)
            ->with('manufacturers', $manufacturers)
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
            'year'            => 'required|max:4',
            'month'           => 'required|max:2',
            'manufacturer_id' => 'required|numeric',
            'vat_deposit'     => 'required|numeric',
            'sd_deposit'      => 'required|numeric',
            'hdsc_deposit'    => 'required|numeric'
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
                    ->orWhere('calendar_period', request('month'))
                    ->first();

                // $data = new Deposit();
                // $data->calendar_id = $calendar_data->id;
                // $data->manufacturer_id = request('manufacturer_id');
                // $data->vat_deposit = request('vat_deposit');
                // $data->sd_deposit = request('sd_deposit');
                // $data->hdsc_deposit = request('hdsc_deposit');
                // $data->save();

                $data = Deposit::updateOrCreate(
                    ['id' => $request->deposit_id],
                    [
                        'calendar_id'    => $calendar_data->id,
                        'manufacturer_id' => $request->manufacturer_id,
                        'vat_deposit'    => $request->vat_deposit,
                        'sd_deposit'     => $request->sd_deposit,
                        'hdsc_deposit'   => $request->hdsc_deposit,
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
        $deposit = Deposit::with('calendar')->find($id);
        return response()->json($deposit);
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
        Deposit::find($id)->delete();

        return response()->json(['success' => 'true', 'message' => 'Deposit Record Has Been Deleted!']);
    }

    public function import(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'import_file' => 'required|mimes:csv,txt'
        ]);

        if ($validatedData->fails()) {
            return response()->json(
                ['message' => $validatedData->errors()->all()],400
            );
        } else {
            try {

                Excel::import(new DepositImport, request()->file('import_file'));
                
            } catch (ValidationException $e) {
                $failures = $e->failures();
                $jsonOutput = [];

                foreach ($failures as $failure) {
                    $jsonOutput[$failure->attribute()] = $failure->errors();
                }
                return response()->json(['message' => $jsonOutput], 400);
            }
            return response()->json(['success'=> 'File Uploaded Successfully!']);

        }
    }
    
}
