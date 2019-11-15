<?php

namespace App\Google;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Google;

class GoogleWebMaster
{
    private $search_console;

    public function __construct()
    {
        return $google_Client = Google::getClient();
    }

    public function get_refresh_token()
    {
        $google_Client->setAccessToken($user_access_token);
        $google_analytics = Google::make('analytics');
    }
}
