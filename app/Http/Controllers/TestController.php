<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use Auth;
use DB;
use Route;

use App\User;
use App\AddSites;

use App\Mail\CustomerSendmail;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $action_url = URL::signedRoute('report-pdf.one-month', ['AddSites' => 36]);
        $site = AddSites::where('id', 36)->first();
        $site_name = $site->site_name;
        $site_url = $site->url;
        \Mail::to('anyushu2017@gmail.com')->send(new CustomerSendmail($site_url, $action_url));
    }
}
