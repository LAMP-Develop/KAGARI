<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
use Google_Service_Webmasters_SearchAnalyticsQueryRequest;
use Google_Service_Webmasters_ApiDimensionFilter;
use Google_Service_Webmasters_ApiDimensionFilterGroup;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('webmaster');
    }

    // SEOページキーワード
    public function get_seo_kyes(Request $request)
    {
        $limit = 1;
        $url = $request->url;
        $contetn_url_json = $request->content_url;
        $content_url = json_decode($contetn_url_json, true);
        $start = $request->start;
        $end = $request->end;
        $sc = $request->sc;
        $sc_re = $this->get_sc_data($sc, $url, $content_url, $start, $end, $limit);
        if (count($sc_re) == 0) {
            $kye = '';
        } else {
            $kye = $sc_re->rows[0]['keys'][0];
        }
        return Response::json($kye);
    }

    // SEOページ詳細
    public function get_seo_detail(Request $request)
    {
        $limit = 100;
        $url = $request->url;
        $content_url = $request->content_url;
        $start = $request->start;
        $end = $request->end;
        $sc = $request->sc;
        $sc_re = $this->get_sc_data($sc, $url, $content_url, $start, $end, $limit = 100);
        return Response::json($sc_re->rows);
    }

    // プライマリーSC
    public function get_sc_data($sc, $url, $content_url, $start, $end, $limit = 100)
    {
        try {
            $query = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
            $query->setRowLimit($limit);
            $query->setStartDate($start);
            $query->setEndDate($end);
            $query->setDimensions(['query']);
            if ($content_url != '') {
                $filter = new Google_Service_Webmasters_ApiDimensionFilter();
                $filter->setDimension('page');
                $filter->setOperator('equals');
                $filter->setExpression($content_url);
                $filters = new Google_Service_Webmasters_ApiDimensionFilterGroup();
                $filters->setFilters([$filter]);
                $query->setDimensionFilterGroups([$filters]);
            }
            $resulets = $sc->searchanalytics->query($url, $query);
        } catch (\Exception $e) {
            $resulets = [];
        }
        return $resulets;
    }
}
