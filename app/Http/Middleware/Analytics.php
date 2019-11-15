<?php

namespace App\Http\Middleware;

use Closure;
use Google;
use Auth;

class Analytics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $user_access_token = $user->google_token;
        $user_refresh_token = $user->google_refresh_token;
        $google_client = Google::getClient();
        $google_client->setAccessToken($user_access_token);
        $google_analytics = Google::make('Analytics');
        $request->merge(['ga' => $google_analytics]);
        try {
            $google_analytics->management_webproperties->listManagementWebproperties('~all');
        } catch (\Exception $e) {
            $refresh = $google_Client->refreshToken($user_refresh_token);
            $user->google_token = $refresh['access_token'];
            $user->google_refresh_token = $refresh['refresh_token'];
            $user->update();
            $google_client->setAccessToken($refresh['access_token']);
            $google_analytics = Google::make('Analytics');
            $request->merge(['ga' => $google_analytics]);
        }
        return $next($request);
    }
}
