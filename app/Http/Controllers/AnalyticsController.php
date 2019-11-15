<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google;

class GoogleAnalytics extends Controller
{
    private $analytics;

    public function __construct()
    {
        return $google_Client = Google::getClient();
    }

    public function set_properties()
    {
        $google_Client->setAccessToken($user_access_token);
        $google_analytics = Google::make('analytics');
    }
}
