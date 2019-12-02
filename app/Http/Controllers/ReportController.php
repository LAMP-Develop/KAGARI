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

    public function index(Request $request, $sites)
    {
        $add_site = AddSites::where('id', $sites)->get()[0];
        $site_name = $add_site->site_name;
        $view_id =(string)$add_site->VIEW_ID;
        $url = $add_site->url;
        $gsa = $request->ga_report;
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $com_end = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $com_start = date('Y-m-d', strtotime('-29 days', strtotime($com_end)));
        // $ga_result = $this->get_ga_data($gsa, $view_id, $start, $end, $comStart, $comEnd)[0];
        // $ga_user = $this->get_ga_user($gsa, $view_id, $start, $end, $comStart, $comEnd);
        // $ga_action = $this->get_ga_cv($gsa, $view_id, $start, $end, $comStart, $comEnd);
        return view('analysis.report.index')->with([
          // 'ga_result' => $ga_result,
          'add_site' => $add_site,
          'end' => $end,
          'start' => $start,
          'com_end' => $com_end,
          'com_start' => $com_start
        ]);
    }

    // サマリー
    public function get_ga_data($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $dateRangeTwo = new Google_Service_AnalyticsReporting_DateRange();
        $dateRangeTwo->setStartDate($comStart);
        $dateRangeTwo->setEndDate($comEnd);
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:pageviewsPerSession');
        $up = new Google_Service_AnalyticsReporting_Metric();
        $up->setExpression('ga:users');
        $time = new Google_Service_AnalyticsReporting_Metric();
        $time->setExpression('ga:avgTimeOnPage');
        $br = new Google_Service_AnalyticsReporting_Metric();
        $br->setExpression('ga:bounceRate');
        $aveSs = new Google_Service_AnalyticsReporting_Metric();
        $aveSs->setExpression('ga:avgSessionDuration');
        $pv = new Google_Service_AnalyticsReporting_Metric();
        $pv->setExpression('ga:pageviews');
        $exit = new Google_Service_AnalyticsReporting_Metric();
        $exit->setExpression('ga:exitRate');
        $date = new Google_Service_AnalyticsReporting_Dimension();
        $date->setName('ga:date');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:sessions');
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges(array($dateRange,$dateRangeTwo));
        $request->setMetrics(array($ss, $ps, $up, $time, $br, $aveSs, $pv, $exit));
        $requestUser = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestUser->setViewId($VIEW_ID);
        $requestUser->setDateRanges(array($dateRange, $dateRangeTwo));
        $requestUser->setMetrics($up);
        $requestUser->setDimensions($date);
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request, $requestUser));
        $result = $analytics->reports->batchGet($body)->reports[0]->data->totals;
        $resultUsers = $analytics->reports->batchGet($body)->reports[1]->data->rows;
        $arrayUser = [];
        $array = [];
        foreach ($resultUsers as $i => $resultUser) {
            $day = date('Y-m-d', strtotime($resultUser->dimensions[0]));
            if ($i <= 29) {
                $user = $resultUser->metrics[1]->values[0];
                $arrayUser['compare'][$day] = $user;
            }
            if ($i >=30) {
                $user = $resultUser->metrics[0]->values[0];
                $arrayUser['original'][$day] = $user;
            }
            $i++;
        }
        foreach ($result as $key => $value) {
            $value = $value->values;
            array_push($array, $value);
        }
        return [$array, $arrayUser];
    }

    // ユーザーサマリー
    public function get_ga_user($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $dateRangeTwo = new Google_Service_AnalyticsReporting_DateRange();
        $dateRangeTwo->setStartDate($comStart);
        $dateRangeTwo->setEndDate($comEnd);
        $city = new Google_Service_AnalyticsReporting_Dimension();
        $city->setName('ga:city');
        $country = new Google_Service_AnalyticsReporting_Dimension();
        $country->setName('ga:country');
        $gender = new Google_Service_AnalyticsReporting_Dimension();
        $gender->setName('ga:userGender');
        $age = new Google_Service_AnalyticsReporting_Dimension();
        $age->setName('ga:userAgeBracket');
        $device = new Google_Service_AnalyticsReporting_Dimension();
        $device->setName('ga:deviceCategory');
        $userType = new Google_Service_AnalyticsReporting_Dimension();
        $userType->setName('ga:userType');
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $ss->setAlias('ss');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:sessions');
        $orderBy->setSortOrder('DESCENDING');
        $requestCity = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestCity->setViewId($VIEW_ID);
        $requestCity->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestCity->setMetrics($ss);
        $requestCity->setDimensions($city);
        $requestCity->setOrderBys($orderBy);
        $requestCity->setPageSize('5');
        $requestCountry = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestCountry->setViewId($VIEW_ID);
        $requestCountry->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestCountry->setMetrics($ss);
        $requestCountry->setDimensions($country);
        $requestCountry->setOrderBys($orderBy);
        $requestCountry->setPageSize('5');
        $requestGender = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestGender->setViewId($VIEW_ID);
        $requestGender->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestGender->setMetrics($ss);
        $requestGender->setDimensions($gender);
        $requestGender->setOrderBys($orderBy);
        $requestAge = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestAge->setViewId($VIEW_ID);
        $requestAge->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestAge->setMetrics($ss);
        $requestAge->setDimensions($age);
        $requestAge->setOrderBys($orderBy);
        $requestDevice = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestDevice->setViewId($VIEW_ID);
        $requestDevice->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestDevice->setMetrics($ss);
        $requestDevice->setDimensions($device);
        $requestDevice->setOrderBys($orderBy);
        $requestUserType = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestUserType->setViewId($VIEW_ID);
        $requestUserType->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestUserType->setMetrics($ss);
        $requestUserType->setDimensions($userType);
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($requestCountry, $requestCity, $requestAge));
        $bodyTwo = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $bodyTwo->setReportRequests(array($requestUserType, $requestDevice, $requestGender));
        $reports = $analytics->reports->batchGet($body)->reports;
        $reportsTwo = $analytics->reports->batchGet($bodyTwo)->reports;
        $number = [];
        $numberUser = [];
        foreach ($reportsTwo as $i => $value) {
            $rows = $value->data->rows;
            foreach ($rows as $key => $val) {
                $dimension = $val->dimensions[0];
                $number[$i][$dimension] = [$val->metrics[0]->values[0],$val->metrics[1]->values[0]];
            }
        }
        foreach ($reports as $i => $value) {
            $rows = $value->data->rows;
            foreach ($rows as $key => $val) {
                $numberUser[$i][] = [$val->dimensions[0], $val->metrics[0]->values[0], $val->metrics[1]->values[0]];
            }
        }
        return [$number,$numberUser];
    }

    // CV解析
    public function get_ga_cv($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $dateRangeTwo = new Google_Service_AnalyticsReporting_DateRange();
        $dateRangeTwo->setStartDate($comStart);
        $dateRangeTwo->setEndDate($comEnd);
        $action = new Google_Service_AnalyticsReporting_Dimension();
        $action->setName('ga:sourceMedium');
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $up = new Google_Service_AnalyticsReporting_Metric();
        $up->setExpression('ga:users');
        $br = new Google_Service_AnalyticsReporting_Metric();
        $br->setExpression('ga:bounceRate');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:pageviewsPerSession');
        $time = new Google_Service_AnalyticsReporting_Metric();
        $time->setExpression('ga:avgTimeOnPage');
        $cv = new Google_Service_AnalyticsReporting_Metric();
        $cv->setExpression('ga:goalCompletionsAll');
        $cvr = new Google_Service_AnalyticsReporting_Metric();
        $cvr->setExpression('ga:goalConversionRateAll');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:users');
        $orderBy->setSortOrder('DESCENDING');
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges(array($dateRange, $dateRangeTwo));
        $request->setDimensions($action);
        $request->setMetrics(array($cv,$cvr,$up,$br,$ps,$time));
        $request->setOrderBys($orderBy);
        $request->setPageSize('10');
        $requestTwo = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestTwo->setViewId($VIEW_ID);
        $requestTwo->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestTwo->setMetrics(array($ss, $cv, $cvr, $br));
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request, $requestTwo));
        $reports = $analytics->reports->batchGet($body);
        $reportsOne = $reports[0]->data->rows;
        $reportsTwo = $reports[1]->data->totals;
        foreach ($reportsOne as $key => $report) {
            $number[$key][0][] = [$report->dimensions,$report->metrics[0]->values[0],$report->metrics[0]->values[1],$report->metrics[0]->values[2],$report->metrics[0]->values[3],$report->metrics[0]->values[4],$report->metrics[0]->values[5]];
            $number[$key][1][]= [$report->dimensions,$report->metrics[1]->values[0],$report->metrics[1]->values[1],$report->metrics[1]->values[2],$report->metrics[1]->values[3],$report->metrics[1]->values[4],$report->metrics[1]->values[5]];
        }
        $array = [];
        foreach ($reportsTwo as $value) {
            $value = $value->values;
            array_push($array, $value);
        }
        return [$number,$array];
    }
}
