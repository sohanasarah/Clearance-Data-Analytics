<?php

namespace clearance_data_analytics\Http\Controllers\Master;

use Illuminate\Http\Request;
use clearance_data_analytics\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }
}
