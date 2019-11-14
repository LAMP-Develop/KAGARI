<?php
namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use App\Google;
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

class Google extends Model
{
    // OAuth認証
    public function client()
    {
        $client_id = env('GOOGLE_CLIENT_ID');
        $client_secret = env('GOOGLE_CLIENT_SECRET');
        $redirect_url = url('/').'/auth/google/callback';
        $KEY_FILE_LOCATION = '../client_secret.json';
        $gScope = "https://www.googleapis.com/auth/analytics.readonly,https://www.googleapis.com/auth/webmasters.readonly";
        $access_type = 'offline';
        $approval_prompt = 'force';
        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_url);
        $client->setScopes(explode(',', $gScope));
        $client->setAuthConfigFile($KEY_FILE_LOCATION);
        $client->setApprovalPrompt($approval_prompt);
        $client->setAccessType($access_type);
        return $client;
    }
    // Google Refresh
    public function get_refresh_token($client, $user)
    {
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = new \Google_Client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
    }
    // GAのプロパティ取得
    public function get_properties($client)
    {
        $array = $client->management_webproperties->listManagementWebproperties('~all');
        return $array;
    }
    // GAのアカウント取得
    public function get_account_data($properties)
    {
        $name = [];
        foreach ($properties as $key => $value) {
            array_push(
                $name,
                array(
                  $value->accountId,
                  $value->name,
                  $value->websiteUrl,
                  $value->id,
                  $value->defaultProfileId,
                )
            );
        }
        return $name;
    }
    // GAの値取得
    public function get_ga_data($analytics, $VIEW_ID, $start, $end, $page_token = '0')
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $pv = new Google_Service_AnalyticsReporting_Metric();
        $pv->setExpression('ga:pageviews');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:pageviewsPerSession');
        $up = new Google_Service_AnalyticsReporting_Metric();
        $up->setExpression('ga:users');
        $time = new Google_Service_AnalyticsReporting_Metric();
        $time->setExpression('ga:avgTimeOnPage');
        $br = new Google_Service_AnalyticsReporting_Metric();
        $br->setExpression('ga:bounceRate');
        $val = new Google_Service_AnalyticsReporting_Metric();
        $val->setExpression('ga:pageValue');
        $cv = new Google_Service_AnalyticsReporting_Metric();
        $cv->setExpression('ga:goalCompletionsAll');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:avgPageLoadTime');
        $title = new Google_Service_AnalyticsReporting_Dimension();
        $title->setName('ga:pageTitle');
        $path = new Google_Service_AnalyticsReporting_Dimension();
        $path->setName('ga:pagePath');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:sessions');
        $orderBy->setSortOrder('DESCENDING');
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($ss, $pv, $ps, $up, $time, $br, $val, $cv, $ps));
        $request->setDimensions(array($title, $path));
        $request->setOrderBys($orderBy);
        $request->setPageToken($page_token);
        $request->setPageSize('100');
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request));
        $reports = $analytics->reports->batchGet($body);
        $rowCount = $reports[0]->data->rowCount;
        $result = [];
        $result['counts'][] = $rowCount;
        for ($reportIndex = 0; $reportIndex < count($reports); ++$reportIndex) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();
            for ($rowIndex = 0; $rowIndex < count($rows); ++$rowIndex) {
                $row = $rows[$rowIndex];
                $dimensions = $row->getDimensions();
                $metrics = $row->getMetrics();
                $result['rows'][$rowIndex] = [];
                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); ++$i) {
                    array_push($result['rows'][$rowIndex], $dimensions[$i]);
                }
                for ($j = 0; $j < count($metricHeaders) && $j < count($metrics); ++$j) {
                    $entry = $metricHeaders[$j];
                    $values = $metrics[$j];
                    for ($valueIndex = 0; $valueIndex < count($values->getValues()); ++$valueIndex) {
                        $value = $values->getValues()[$valueIndex];
                        array_push($result['rows'][$rowIndex], $value);
                    }
                }
            }
        }
        return $result;
    }
    // 全ページGAの値取得
    public function get_ga_all_data($analytics, $VIEW_ID, $start, $end)
    {
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        $ss = new Google_Service_AnalyticsReporting_Metric();
        $ss->setExpression('ga:sessions');
        $pv = new Google_Service_AnalyticsReporting_Metric();
        $pv->setExpression('ga:pageviews');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:pageviewsPerSession');
        $up = new Google_Service_AnalyticsReporting_Metric();
        $up->setExpression('ga:users');
        $time = new Google_Service_AnalyticsReporting_Metric();
        $time->setExpression('ga:avgTimeOnPage');
        $br = new Google_Service_AnalyticsReporting_Metric();
        $br->setExpression('ga:bounceRate');
        $cv = new Google_Service_AnalyticsReporting_Metric();
        $cv->setExpression('ga:goalCompletionsAll');
        $ps = new Google_Service_AnalyticsReporting_Metric();
        $ps->setExpression('ga:avgPageLoadTime');
        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
        $orderBy->setFieldName('ga:sessions');
        $orderBy->setSortOrder('DESCENDING');
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($ss, $pv, $ps, $up, $time, $br, $ps, $cv));
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests(array($request));
        $result = $analytics->reports->batchGet($body)->reports[0]->data->totals[0]->values;
        return $result;
    }
    // SCの取得
    public function search_analytics($url, $content_url, $limit, $gsw, $start, $end)
    {
        $query = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $query->setRowLimit($limit);
        $query->setDimensions(['query']);
        $query->setStartDate($start);
        $query->setEndDate($end);
        $query->setSearchType('web');
        $filter = new Google_Service_Webmasters_ApiDimensionFilter();
        $filter->setDimension('page');
        $filter->setOperator('equals');
        $filter->setExpression($content_url);
        $filters = new Google_Service_Webmasters_ApiDimensionFilterGroup();
        $filters->setFilters([$filter]);
        $query->setDimensionFilterGroups([$filters]);
        return $resulets = $gsw->searchanalytics->query($url, $query);
    }
    // SCのページ単位取得
    public function search_analytics_page($url, $content_url, $limit, $gsw, $start, $end)
    {
        $query = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $query->setRowLimit($limit);
        $query->setDimensions(['page']);
        $query->setStartDate($start);
        $query->setEndDate($end);
        $filter = new Google_Service_Webmasters_ApiDimensionFilter();
        $filter->setDimension('page');
        $filter->setOperator('equals');
        $filter->setExpression($content_url);
        $filters = new Google_Service_Webmasters_ApiDimensionFilterGroup();
        $filters->setFilters([$filter]);
        $query->setDimensionFilterGroups([$filters]);
        return $resulets = $gsw->searchanalytics->query($url, $query);
    }
    // SCのページ単位取得
    public function get_sc_page($url, $limit, $gsw, $start, $end)
    {
        try {
            $query = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
            $query->setRowLimit($limit);
            $query->setStartDate($start);
            $query->setEndDate($end);
            $query->setDimensions(['page']);
            return $resulets = $gsw->searchanalytics->query($url, $query)->rows;
        } catch (\Exception $e) {
            return $e;
        }
    }
    // SC全体取得
    public function get_all_sc($url, $gsw, $start, $end)
    {
        try {
            $query = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
            $query->setStartDate($start);
            $query->setEndDate($end);
            $query->setSearchType('web');
            return $resulets = $gsw->searchanalytics->query($url, $query)->rows[0];
        } catch (\Exception $e) {
            return $e;
        }
    }
}
