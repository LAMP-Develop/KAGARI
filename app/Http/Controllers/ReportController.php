<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\AddSites;
use App\Plans;
use Auth;
use Google;
use DB;

use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_SegmentDimensionFilter;
use Google_Service_AnalyticsReporting_DimensionFilterClause;
use Google_Service_AnalyticsReporting_OrderBy;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('analytics.reporting');
    }

    public function index(Request $request, $id)
    {
        $addSite = AddSites::find($id)->first();
        $site_name = $addSite->site_name;
        $view_id =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $gsa = $request->ga_report;
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        // $ga_result = $google->get_ga_data($gsa, $view_id, $start, $end, $comStart, $comEnd);
        // $ga_result = $ga_result[0];
        // $ga_user = $google->get_ga_user($gsa, $view_id, $start, $end, $comStart, $comEnd);
        // $ga_action = $google->get_ga_cv($gsa, $view_id, $start, $end, $comStart, $comEnd);
        return view('analysis.report.index')->with([
          // 'ga_result'=>$ga_result,
          // 'add_sites'=>$add_sites,
          // 'addSite'=>$addSite,
          'start'=>$start,
          'end'=>$end,
          'view_id'=>$view_id,
          'url'=>$url,
          'site_name'=>$site_name
        ]);
    }
}
