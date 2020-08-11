<?php

namespace clearance_data_analytics\Http\Controllers\Users;

use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use clearance_data_analytics\Segment;

class SegmentController extends Controller
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
        $list =  Segment::orderBy('id','asc')->get();
        return view('master.segments.index')->with('list', $list);
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
            'internal_segment' => 'required|max:24',
            'external_segment1' => 'required|max:24',
            'external_segment2' => 'nullable|max:24',
            'status'  => 'required'
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
                $data = Segment::updateOrCreate(
                    ['id' => $request->segment_id],
                    [
                        'internal_segment'  => $request->internal_segment,
                        'external_segment1' => $request->external_segment1,
                        'external_segment2' => $request->external_segment2,
                        'status'            => $request->status
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
        //
        $segment = Segment::find($id);
        return response()->json($segment);
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
        Segment::find($id)->delete();

        return response()->json(['success' => 'true','message'=>'Segment Has Been Deleted!']);
    }
}
