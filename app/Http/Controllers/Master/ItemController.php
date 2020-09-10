<?php

namespace clearance_data_analytics\Http\Controllers\Master;

use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;
use clearance_data_analytics\Brand;
use clearance_data_analytics\Item;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('brand')->orderBy('id', 'asc')->get();

        /*for dropdown options*/
        $brands = Brand::where('status', 'active')->orderBy('id')->get(['id', 'brand_name']);


        return view('master.items.index')->with('items', $items)
            ->with('brands', $brands);
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
            'item_code' => 'required|max:16',
            'item_name' => 'required|max:48',
            'brand_id' => 'required',
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
                // $data = new Item();
                // $data->item_code = request('item_code');
                // $data->item_name = request('item_name');
                // $data->brand_id = request('brand_id');
                // $data->status = request('status');
                // $data->save();

                $data = Item::updateOrCreate(
                    ['id' => $request->item_id],
                    [
                        'item_name'       => $request->item_name,
                        'item_code'       => $request->item_code,
                        'brand_id'        => $request->brand_id,
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
        $item = Item::find($id);
        return response()->json($item);
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
        Item::find($id)->delete();
        return response()->json(['success' => 'true', 'message'=>'Item has been deleted!']);

    }
}
