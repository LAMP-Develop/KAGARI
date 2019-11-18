<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Industry;
use DB;
use Auth;
use AddSites;

class AddSitesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('analytics.properties');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $properties = [];

        $categories = Category::all();
        $industries = Industry::all();
        $ga = $request->ga;
        $accounts = $ga->management_accounts->listManagementAccounts()->getItems();
        $property = $ga->management_webproperties->listManagementWebproperties('~all')->getItems();
        foreach ($accounts as $key => $account) {
            $temp_array = [];
            $id = $account->getId();
            $name = $account->getName();
            foreach ($property as $key => $val) {
                if ($id == $val['accountId']) {
                    $temp_array[$val['defaultProfileId']] = [
                    'name' => $val['name'],
                    'url' => $val['websiteUrl']
                  ];
                }
            }
            $properties[$id] = [
              'account_name' => $name,
              'data' => $temp_array
            ];
        }
        return view('account.addsite')->with([
          'properties' => $properties,
          'categories' => $categories,
          'industries' => $industries,
        ]);
    }

    public function plan(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $site_name = $request['site-name'];
        $view_id = (int)$request['view-id'];
        $industries = $request['industries'];
        $genre = $request['genre'];
        $url = $request['site-url'];

        DB::table('add_sites')->insert([
            'user_id' => $user->id,
            'site_name' => $request['site-name'],
            'VIEW_ID' => $request['view-id'],
            'industry' => $request['industries'],
            'category' => $request['genre'],
            'url' => $request['site-url'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return view('account.plan');
    }
}
