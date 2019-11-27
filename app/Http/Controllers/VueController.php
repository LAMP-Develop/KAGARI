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

class VueController extends Controller
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

    // NavBar
    public function nav(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $url = $addSite->url;
        $siteName = $addSite->site_name;
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-100 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-100 days', strtotime($comEnd)));
        $site_info = [$url,$siteName,$start,$end,$comStart,$comEnd];
        return $data = [
            "site_info"=>$site_info
        ];
    }
    // サマリー
    public function analytics(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $VIEW_ID =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $siteName = $addSite->site_name;
        $site_info = [$url,$siteName];
        $client = $google->client();
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client ->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = $google->client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
        $gsa = new Google_Service_AnalyticsReporting($client);
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        $ga_result = $google->get_ga_data($gsa, $VIEW_ID, $start, $end, $comStart, $comEnd);
        $originResult = $ga_result[0][0];
        $comResult = $ga_result[0][1];
        $originUser = $ga_result[1]['original'];
        $compareUser = $ga_result[1]['compare'];
        $ss = $originResult[0];
        $ps = $originResult[1];
        $user = $originResult[2];
        $time = $originResult[3];
        $br = $originResult[4];
        $aveSs = $originResult[5];
        $pv = $originResult[6];
        $exit = $originResult[7];
        $comSS = $comResult[0];
        $comPs = $comResult[1];
        $comUser = $comResult[2];
        $comTime = $comResult[3];
        $comBr = $comResult[4];
        $comAveSs = $comResult[5];
        $comPv = $comResult[6];
        $comExit = $comResult[7];
        $site_info = [$url,$siteName,$start,$end,$comStart,$comEnd];
        $data =[
            "session"=>$ss,
            "pSession"=>$ps,
            "user"=>$user,
            "time"=>$time,
            "bRate"=>$br,
            "aveSs"=>$aveSs,
            "pv"=>$pv,
            "exit"=>$exit,
            "comSession"=>$comSS,
            "comPSession"=>$comPs,
            "comUser"=>$comUser,
            "comTime"=>$comTime,
            "comBRate"=>$comBr,
            "originUser"=>$originUser,
            "compareUser"=>$compareUser,
            "comAveSs"=>$comAveSs,
            "comPv"=>$comPv,
            "comExit"=>$comExit,
            "site_info"=>$site_info
        ];

        return $data;
    }
    // ユーザー分析
    public function user(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $VIEW_ID =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $client = $google->client();
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client ->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = $google->client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
        $gsa = new Google_Service_AnalyticsReporting($client);
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        $ga_user = $google->get_ga_user($gsa, $VIEW_ID, $start, $end, $comStart, $comEnd);
        $ga_userOne = $ga_user[0];
        $ga_userType = $ga_user[1];
        $data = [
            "user"=>$ga_userOne,
            "userTypes"=>$ga_userType
        ];
        return $data;
    }
    // 流入元分析
    public function inflow(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $VIEW_ID =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $client = $google->client();
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client ->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = $google->client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
        $gsa = new Google_Service_AnalyticsReporting($client);
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        $ga_inflow = $google->get_ga_inflow($gsa, $VIEW_ID, $start, $end, $comStart, $comEnd);
        $data = ["inflow"=>$ga_inflow];
        return $data;
    }
    // ユーザー行動分析
    public function action(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $VIEW_ID =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $client = $google->client();
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client ->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = $google->client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
        $gsa = new Google_Service_AnalyticsReporting($client);
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));

        $ga_action = $google->get_ga_action($gsa, $VIEW_ID, $start, $end, $comStart, $comEnd);
        $data = $ga_action;

        return $data;
    }

    public function cv(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $VIEW_ID =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $client = $google->client();
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client ->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = $google->client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
        $gsa = new Google_Service_AnalyticsReporting($client);
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        $ga_cv = $google->get_ga_cv($gsa, $VIEW_ID, $start, $end, $comStart, $comEnd);
        $ga_cvOne = $ga_cv[0];
        $ga_cvTwo = $ga_cv[1];
        $data = [
            "cv"=>$ga_cvTwo,
            "cvReport"=>$ga_cvOne
        ];
        return $data;
    }

    public function ad(Google $google, AddSite $addSite)
    {
        $user = Auth::user();
        $id =  $user->id;
        $add_sites = AddSite::where('user_id', $id)->get();
        if (empty($add_sites) || $add_sites == []) {
            return redirect('/accounts.google');
        }
        $addSite = AddSite::where('user_id', $id)->first();
        if (is_null($addSite)) {
            return redirect('/accounts.google');
        }
        $VIEW_ID =(string)$addSite->VIEW_ID;
        $url = $addSite->url;
        $client = $google->client();
        $timeCreated = $user->createdAtToken;
        $refreshToken = $user->refresh_token;
        $time = time();
        $timeDifference = $time - $timeCreated;
        if ($timeDifference < 3600) {
            $accessToken = $user->Gtoken;
            $client->setAccessToken($accessToken);
        } elseif ($timeDifference > 3600) {
            try {
                $client = $client ->refreshToken($refreshToken);
                $newTimeCreated = $client['created'];
                $newAccessToken = $client['access_token'];
                $newRefreshToken = $client['refresh_token'];
                $user->Gtoken = $newAccessToken;
                $user->refresh_token = $newRefreshToken;
                $user->createdAtToken = $newTimeCreated;
                $user->update();
                $client = $google->client();
                $accessToken = $user->Gtoken;
                $client->setAccessToken($accessToken);
            } catch (ErrorException $e) {
                return redirect('login');
            }
        }
        $gsa = new Google_Service_AnalyticsReporting($client);
        $end = date('Y-m-d', strtotime('-1 day', time()));
        $start = date('Y-m-d', strtotime('-30 days', time()));
        $comEnd = date('Y-m-d', strtotime('-1 day', strtotime($start)));
        $comStart = date('Y-m-d', strtotime('-29 days', strtotime($comEnd)));
        $ga_ad = $google->get_ga_ad($gsa, $VIEW_ID, $start, $end, $comStart, $comEnd);
        $ga_adOne = $ga_ad[0];
        $ga_adTwo = $ga_ad[1];
        $data = [
            "cv"=>$ga_adOne,
            "cvReport"=>$ga_adTwo
        ];
        return $data;
    }
}
