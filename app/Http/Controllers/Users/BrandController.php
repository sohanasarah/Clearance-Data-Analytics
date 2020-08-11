<?php

namespace clearance_data_analytics\Http\Controllers\Users;

use clearance_data_analytics\Brand;
use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use clearance_data_analytics\Manufacturer;
use clearance_data_analytics\Segment;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
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
        /* Brand table joining manufacturer,segment tables (one to one relationship). Configuration done in Models */
        $brands = Brand::with('manufacturer', 'segment')->orderBy('id','asc')->get();

        /* for dropdown options */
        $manufacturers = Manufacturer::where('status','active')->orderBy('id')->get(['id', 'short_name']);
        $segments = Segment::where('status','active')->orderBy('id')->get(['id', 'internal_segment']);

        return view('master.brands.index')->with('brands',$brands)
                                        ->with('manufacturers', $manufacturers)
                                        ->with('segments', $segments);
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
            'brand_name' => 'required|max:48',
            'short_name' => 'required|max:24',
            'segment_id' => 'required',
            'manufacturer_id' => 'required',
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
                // $data = new Brand();
                // $data->brand_name = request('brand_name');
                // $data->short_name = request('short_name');
                // $data->manufacturer_id = request('manufacturer_id');
                // $data->segment_id = request('segment_id');
                // $data->status = request('status');
                // $data->save();

                $data = Brand::updateOrCreate(
                    ['id' => $request->brand_id],
                    [
                        'brand_name'      => $request->brand_name,
                        'short_name'      => $request->short_name,
                        'segment_id'      => $request->segment_id,
                        'manufacturer_id' => $request->manufacturer_id,
                        'status'          => $request->status
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
        $brand = Brand::find($id);
        return response()->json($brand);
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
        Brand::find($id)->delete();
        return response()->json(['success' => 'true','message'=>'Brand Has Been Deleted!']);
    }
}
