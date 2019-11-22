<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AddSites;
use App\Category;
use App\Industry;
use Auth;
use DB;

class AddSitesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 常に発火する場合は下記のように
        // $this->middleware('analytics.properties');
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

    // プラン選択
    public function plan(Request $request)
    {
        $user = Auth::user();
        $site_id = $request['site-id'];
        $site_url = $request['site-url'];
        $e_message = '';
        $sc_site = '';
        $flag = DB::table('add_sites')->where([
          ['user_id', $user->id],
          ['VIEW_ID', $request['view-id']]
        ])->get();
        if (!count($flag) > 0) {
            if (!isset($request['site-id'])) {
                $add_sites = new AddSites();
                $add_sites->user_id = $user->id;
                $add_sites->site_name = $request['site-name'];
                $add_sites->VIEW_ID = $request['view-id'];
                $add_sites->industry = $request['industries'];
                $add_sites->category = $request['genre'];
                $add_sites->url = $site_url;
                $add_sites->created_at = date('Y-m-d H:i:s');
                $add_sites->updated_at = date('Y-m-d H:i:s');
                $add_sites->save();
                $site_id = $add_sites->id;
            }
        }
        try {
            $sc_site = $request->sc->sites->get($site_url)->siteUrl;
        } catch (\Exception $e) {
            $e_message = '選ばれたサイトはSearch Consoleに登録されていません。SEOのプランをご契約される際にはSearch Consoleへサイトをご登録ください。<br><a href="https://kagari.ai/blog/search-console/" target="_blank"><i class="fas fa-link mr-2"></i>Search Consoleの設定方法を見る</a>';
        }
        return view('payment.plan')->with([
          'site_id' => $site_id,
          'e_message' => $e_message
        ]);
    }
}
