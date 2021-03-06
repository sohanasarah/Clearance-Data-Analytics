<?php

namespace clearance_data_analytics\Http\Controllers\Master;

use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use clearance_data_analytics\Imports\ClearanceImport;


class ImportExportController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExportView()
    {
        return view('master.import.import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function export() 
    // {
    //     return Excel::download(new UsersExport, 'users.xlsx');
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:csv,txt'
        ]);

        try {
            Excel::import(new ClearanceImport, request()->file('import_file'));
        } catch (ValidationException $e) {
            // dd($e);
            $failures = $e->failures();

            return back()->withErrors($failures);
        }

        return back()->with('success', 'File Uploaded Successfully!');
    }
}
