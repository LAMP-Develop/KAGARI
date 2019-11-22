<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\AddSites;
use Auth;
use DB;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 常に発火する場合は下記のように
        // $this->middleware('analytics.properties');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $site_id = $request['site-id'];
        $plan = $request['plan'];
        return view('payment.payment');
    }
}
