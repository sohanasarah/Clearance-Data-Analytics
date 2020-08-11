<?php

namespace clearance_data_analytics\Http\Controllers\Users;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use clearance_data_analytics\Manufacturer;

class ManufacturerController extends Controller
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
        $list = Manufacturer::orderBy('id', 'desc')->get();
        return view('master.manufacturers.index')
            ->with('list', $list);
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
            'full_name' => 'required|max:48',
            'short_name' => 'required|max:8',
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
                error_log($request->id);
                $data = Manufacturer::updateOrCreate(
                    ['id' => $request->manufacturer_id],
                    [
                        'full_name' => $request->full_name,
                        'short_name' => $request->short_name,

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
                        'success' => 'false',
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
        $manufacturer = Manufacturer::find($id);
        return response()->json($manufacturer);
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
        Manufacturer::find($id)->delete();

        return response()->json(['success' => 'true','message'=>'Manufacturer Has Been Deleted!']);
    }
}
