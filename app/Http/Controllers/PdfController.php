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
use Route;

use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_SegmentDimensionFilter;
use Google_Service_AnalyticsReporting_DimensionFilter;
use Google_Service_AnalyticsReporting_DimensionFilterClause;
use Google_Service_AnalyticsReporting_OrderBy;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;

class PdfController extends Controller
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
        // 諸々
        $add_site = AddSites::where('id', $sites)->get()[0];
        $site_name = $add_site->site_name;
        $view_id =(string)$add_site->VIEW_ID;
        $url = $add_site->url;
        if ($add_site->logo_path != '') {
            $logo = '/storage/logos/'.$add_site->logo_path;
        } else {
            $logo = '';
        }

        // AnalyticsReporting API インスタンス
        $gsa = $request->ga_report;

        // 期間指定
        if (isset($request->start)) {
            $end = $request->end;
            $start = $request->start;
            $com_end = $request->com_end;
            $com_start = $request->com_start;
        } else {
            $end = date('Y-m-d', strtotime('-1 day', time()));
            $start = date('Y-m-d', strtotime('-30 days', time()));
            $com_end = date('Y-m-d', strtotime('-1 day', strtotime($start)));
            $com_start = date('Y-m-d', strtotime('-29 days', strtotime($com_end)));
        }

        // ルートごとの返り値変更
        $ga_result_data = $this->get_ga_data($gsa, $view_id, $start, $end, $com_start, $com_end);
        $ga_result_user = $this->get_ga_user($gsa, $view_id, $start, $end, $com_start, $com_end);
        $ga_result_inflow = $this->get_ga_inflow($gsa, $view_id, $start, $end, $com_start, $com_end);
        $ga_result_action = $this->get_ga_action($gsa, $view_id, $start, $end, $com_start, $com_end);
        $ga_result_conversion = $this->get_ga_conversion($gsa, $view_id, $start, $end, $com_start, $com_end);
        $ga_result_ad = $this->get_ga_ad($gsa, $view_id, $start, $end, $com_start, $com_end);

        return view('analysis.pdf.index_pdf')->with([
          'ga_result_data'=>$ga_result_data,
          'ga_result_user'=>$ga_result_user,
          'ga_result_inflow'=>$ga_result_inflow,
          'ga_result_action'=>$ga_result_action,
          'ga_result_conversion'=>$ga_result_conversion,
          'ga_result_ad'=>$ga_result_ad,
          'add_site' => $add_site,
          'end' => $end,
          'start' => $start,
          'com_end' => $com_end,
          'com_start' => $com_start,
          'url' => $url,
          'logo' => $logo,
          'site_name' => $site_name
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
        $up = new Google_Service_AnalyticsReporting_Metric();
        $up->setExpression('ga:users');
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $pv = new Google_Service_AnalyticsReporting_Metric();
        $pv->setExpression('ga:pageviews');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:pageviewsPerSession');
        $aveSs = new Google_Service_AnalyticsReporting_Metric();
        $aveSs->setExpression('ga:avgSessionDuration');
        $time = new Google_Service_AnalyticsReporting_Metric();
        $time->setExpression('ga:avgTimeOnPage');
        $exit = new Google_Service_AnalyticsReporting_Metric();
        $exit->setExpression('ga:exitRate');
        $br = new Google_Service_AnalyticsReporting_Metric();
        $br->setExpression('ga:bounceRate');
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
        $comp_array = [];
        foreach ($resultUsers as $i => $resultUser) {
            $day = date('Y-m-d', strtotime($resultUser->dimensions[0]));
            if ($resultUser->metrics[1]->values[0] == 0) {
                $user = $resultUser->metrics[0]->values[0];
                $arrayUser['original'][(string)$day] = (int)$user;
            } else {
                $user = $resultUser->metrics[1]->values[0];
                $arrayUser['compare'][(string)$day] = (int)$user;
            }
            $i++;
        }
        foreach ($result as $key => $value) {
            $value = $value->values;
            array_push($array, $value);
        }
        foreach ($array[0] as $key => $val) {
            $comp_array[] = round(((float)$val / (float)$array[1][$key] - 1) * 100, 2);
        }
        return [
          'transition' => $arrayUser,
          'sumally' => $array,
          'comp' => $comp_array
        ];
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
        $ss->setExpression('ga:users');
        $ss->setAlias('uu');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:users');
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
        $requestAge->setPageSize('5');
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
        return [$number, $numberUser];
    }

    public function get_ga_inflow($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $dateRangeTwo = new Google_Service_AnalyticsReporting_DateRange();
        $dateRangeTwo->setStartDate($comStart);
        $dateRangeTwo->setEndDate($comEnd);
        $medium = new Google_Service_AnalyticsReporting_Dimension();
        $medium->setName('ga:channelGrouping');
        $social = new Google_Service_AnalyticsReporting_Dimension();
        $social->setName('ga:socialNetwork');
        $referral = new Google_Service_AnalyticsReporting_Dimension();
        $referral->setName('ga:fullReferrer');
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $ss->setAlias('ss');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:sessions');
        $orderBy->setSortOrder('DESCENDING');
        $requestMedium = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestMedium->setViewId($VIEW_ID);
        $requestMedium->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestMedium->setMetrics($ss);
        $requestMedium->setPageSize('5');
        $requestMedium->setDimensions($medium);
        $requestMedium->setOrderBys($orderBy);

        $filter_social = new \Google_Service_AnalyticsReporting_DimensionFilter();
        $filter_social->setDimensionName( 'ga:socialNetwork' );
        $filter_social->setNot(true);
        $filter_social->setExpressions( ["(not set)"] );

        $filters_social = new \Google_Service_AnalyticsReporting_DimensionFilterClause();
        $filters_social->setFilters([$filter_social]);

        $requestSocial = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestSocial->setViewId($VIEW_ID);
        $requestSocial->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestSocial->setMetrics($ss);
        $requestSocial->setPageSize('5');
        $requestSocial->setDimensions($social);
        $requestSocial->setDimensionFilterClauses($filters_social);
        $requestSocial->setOrderBys($orderBy);

        $filter = new Google_Service_AnalyticsReporting_DimensionFilter();
        $filter->setDimensionName('ga:sourceMedium');
        $filter->setExpressions(['referral']);
        $filters = new Google_Service_AnalyticsReporting_DimensionFilterClause();
        $filters->setFilters($filter);
        $requestReferral = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestReferral->setViewId($VIEW_ID);
        $requestReferral->setDateRanges(array($dateRange,$dateRangeTwo));
        $requestReferral->setMetrics($ss);
        $requestReferral->setDimensions($referral);
        $requestReferral->setDimensionFilterClauses($filters);
        $requestReferral->setOrderBys($orderBy);
        $requestReferral->setPageSize('5');
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($requestMedium,$requestSocial,$requestReferral));
        $reports = $analytics->reports->batchGet($body)->reports;
        $number = [];
        $result = [];
        foreach ($reports as $i => $value) {
            $rows = $value->data->rows;
            foreach ($rows as $key => $val) {
                $number[$i][] = [$val->dimensions[0], $val->metrics[0]->values[0],$val->metrics[1]->values[0]];
            }
        }
        return $number;
    }

    // 行動分析
    public function get_ga_action($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $dateRangeTwo = new Google_Service_AnalyticsReporting_DateRange();
        $dateRangeTwo->setStartDate($comStart);
        $dateRangeTwo->setEndDate($comEnd);
        $action = new Google_Service_AnalyticsReporting_Dimension();
        $action->setName('ga:pageTitle');
        $path = new Google_Service_AnalyticsReporting_Dimension();
        $path->setName('ga:pagePath');
        $up = new Google_Service_AnalyticsReporting_Metric();
        $up->setExpression('ga:users');
        $br = new Google_Service_AnalyticsReporting_Metric();
        $br->setExpression('ga:bounceRate');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:pageviewsPerSession');
        $time = new Google_Service_AnalyticsReporting_Metric();
        $time->setExpression('ga:avgTimeOnPage');
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $pv = new Google_Service_AnalyticsReporting_Metric();
        $pv->setExpression('ga:pageviews');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:sessions');
        $orderBy->setSortOrder('DESCENDING');
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges(array($dateRange, $dateRangeTwo));
        $request->setDimensions([$action, $path]);
        $request->setMetrics(array($ss,$pv,$ps,$up,$time,$br));
        $request->setOrderBys($orderBy);
        $request->setPageSize('10');
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request));
        $reports = $analytics->reports->batchGet($body);
        $reports = $reports[0]->data->rows;
        foreach ($reports as $key => $report) {
            $number[$key][0][] = [$report->dimensions,$report->metrics[0]->values[0],$report->metrics[0]->values[1],$report->metrics[0]->values[2],$report->metrics[0]->values[3],$report->metrics[0]->values[4],$report->metrics[0]->values[5]];
            $number[$key][1][]= [$report->dimensions,$report->metrics[1]->values[0],$report->metrics[1]->values[1],$report->metrics[1]->values[2],$report->metrics[1]->values[3],$report->metrics[1]->values[4],$report->metrics[1]->values[5]];
        }
        return $number;
    }

    // CV解析
    public function get_ga_conversion($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
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

    // 広告
    public function get_ga_ad($analytics, $VIEW_ID, $start, $end, $comStart, $comEnd)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $dateRangeTwo = new Google_Service_AnalyticsReporting_DateRange();
        $dateRangeTwo->setStartDate($comStart);
        $dateRangeTwo->setEndDate($comEnd);
        $query = new Google_Service_AnalyticsReporting_Dimension();
        $query->setName('ga:adMatchedQuery');
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $cv = new Google_Service_AnalyticsReporting_Metric();
        $cv->setExpression('ga:goalCompletionsAll');
        $cvr = new Google_Service_AnalyticsReporting_Metric();
        $cvr->setExpression('ga:goalConversionRateAll');
        $adCost = new Google_Service_AnalyticsReporting_Metric();
        $adCost->setExpression('ga:adCost');
        $adClicks = new Google_Service_AnalyticsReporting_Metric();
        $adClicks->setExpression('ga:adClicks');
        // $goalValue = new Google_Service_AnalyticsReporting_Metric();
        // $goalValue->setExpression('ga:goalValueAll');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:adClicks');
        $orderBy->setSortOrder('DESCENDING');
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges(array($dateRange,$dateRangeTwo));
        $request->setMetrics(array($adCost, $adClicks, $cv));
        $requestTwo = new Google_Service_AnalyticsReporting_ReportRequest();
        $requestTwo->setViewId($VIEW_ID);
        $requestTwo->setDateRanges(array($dateRange, $dateRangeTwo));
        $requestTwo->setDimensions($query);
        $requestTwo->setMetrics(array($adClicks,$adCost,$ss,$cv,$cvr));
        $requestTwo->setOrderBys($orderBy);
        $requestTwo->setPageSize('10');
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request, $requestTwo));
        $result = $analytics->reports->batchGet($body);
        $result = $analytics->reports->batchGet($body)->reports[0]->data->totals;
        $resultTwo = $analytics->reports->batchGet($body)->reports[1]->data->rows;
        $array = [];
        foreach ($result as $value) {
            $value = $value->values;
            array_push($array, $value);
        }
        foreach ($resultTwo as $key => $report) {
            $number[$key][0][] = [$report->dimensions,$report->metrics[0]->values[0],$report->metrics[0]->values[1],$report->metrics[0]->values[2],$report->metrics[0]->values[3],$report->metrics[0]->values[4]];
            $number[$key][1][]= [$report->dimensions,$report->metrics[1]->values[0],$report->metrics[1]->values[1],$report->metrics[1]->values[2],$report->metrics[1]->values[3],$report->metrics[1]->values[4]];
        }
        return [$array, $number];
    }
}
