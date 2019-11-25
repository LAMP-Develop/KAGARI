<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\AddSites;
use App\Plans;
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
        $site = AddSites::where('id', $site_id)->get();
        $site_name = $site[0]->site_name;
        $site_url = $site[0]->url;
        $plan = Plans::where('id', $request['plan'])->get();
        $plan_name = $plan[0]->name;
        $plan_price = number_format((int)$plan[0]->price);
        $plan_period = $plan[0]->contract_period;
        return view('payment.payment')->with([
            'site_id' => $site_id,
            'site_name' => $site_name,
            'site_url' => $site_url,
            'plan_id' => $request['plan'],
            'plan_name' => $plan_name,
            'plan_price' => $plan_price,
            'plan_period' => $plan_period,
        ]);
    }

    public function done(Request $request)
    {
        AddSites::where('id', (int)$request['site_id'])->update([
          'plan' => (int)$request['plan_id'],
        ]);
        return view('payment.done')->with([
            'site_id' => $request['site_id'],
            'site_name' => $request['site_name'],
            'site_url' => $request['site_url'],
            'plan_name' => $request['plan_name'],
            'plan_price' => $request['plan_price'],
            'plan_period' => $request['plan_period'],
        ]);
    }
}
