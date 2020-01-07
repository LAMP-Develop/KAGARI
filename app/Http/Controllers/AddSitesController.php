<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AddSites;
use App\Category;
use App\Industry;
use App\Plans;
use App\ReportSendDays;
use App\ReportSendMail;
use Auth;
use DB;
use App\Rules\AlphaNumHalf;
use Illuminate\Support\Facades\Storage;

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
                if ($request->file('image_file') != null) {
                    $path = $request->file('image_file')->store('public/logos');
                    $add_sites->logo_path = basename($path);
                }
                $add_sites->created_at = date('Y-m-d H:i:s');
                $add_sites->updated_at = date('Y-m-d H:i:s');
                $add_sites->save();
                $site_id = $add_sites->id;

                $send_days = new ReportSendDays();
                $send_days->site_id = $site_id;
                $send_days->created_at = date('Y-m-d H:i:s');
                $send_days->updated_at = date('Y-m-d H:i:s');
                $send_days->save();

                $send_mail = new ReportSendMail();
                $send_mail->site_id = $site_id;
                $send_mail->created_at = date('Y-m-d H:i:s');
                $send_mail->updated_at = date('Y-m-d H:i:s');
                $send_mail->save();
            }
            $plan = null;
        } else {
            $plan = $flag[0]->plan;
        }
        try {
            $sc_site = $request->sc->sites->get($site_url)->siteUrl;
        } catch (\Exception $e) {
            $e_message = '選ばれたサイトはSearch Consoleに登録されていません。SEOのプランをご契約される際にはSearch Consoleへサイトをご登録ください。';
        }
        if (!isset($site_id)) {
            $message = '選択されたサイトは既に登録済みです。';
        } else {
            $message = '';
        }
        return view('payment.plan')->with([
          'site_id' => $site_id,
          'e_message' => $e_message,
          'message' => $message,
          'site_plan' => $plan,
        ]);
    }

    // サイトの情報変更
    public function edit($sites)
    {
        $user = Auth::user();
        $categories = Category::all();
        $industries = Industry::all();
        $plans = Plans::all();
        $user_id = $user->id;
        $add_sites = AddSites::where('id', $sites)->get();
        return view('sites.edit')->with([
          'add_sites' => $add_sites,
          'categories' => $categories,
          'industries' => $industries,
          'plans' => $plans,
        ]);
    }

    // サイトの情報更新
    public function update($sites, Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $add_sites = AddSites::where('user_id', $user_id)->get();
        $add_site = AddSites::where('id', $sites)->get();
        $site = $add_site[0];
        $path = '/public/logos/'.$site->logo_path;
        if (isset($request['image_file'])) {
            Storage::delete($path);
            $path = $request->file('image_file')->store('public/logos');
            $site->logo_path = basename($path);
        }
        $site->site_name = $request['site_name'];
        $site->category = $request['genre'];
        $site->industry = $request['industries'];
        $site->save();

        return redirect(route('dashboard'));
    }

    // レポート結果受信
    public function send_setting($sites)
    {
        $add_sites = AddSites::where('id', $sites)->first();
        $site_id = $add_sites->id;

        $mail = [];
        $mail['cc'] = '';
        $days = [];
        $mail_setting = ReportSendMail::where('site_id', $site_id)->get();
        $days_setting = ReportSendDays::where('site_id', $site_id)->get();

        foreach ($mail_setting as $key => $val) {
            if ($val->to_cc == 0) {
                $mail['to'] = $val->mailaddress;
            } else {
                $mail['cc'] .= $val->mailaddress.',';
            }
        }
        $mail['cc'] = rtrim($mail['cc'], ',');

        foreach ($days_setting as $key => $val) {
            $days["$val->days"] = 1;
        }

        return view('sites.send')->with([
            'add_sites' => $add_sites,
            'mail' => $mail,
            'days' => $days,
        ]);
    }

    // レポート結果受信スケジュール更新
    public function send_setting_update($sites, Request $request)
    {
        $validatedData = $request->validate([
            'to_email' => 'required|string|email|max:255'
        ]);

        $site_id = $sites;
        $send_flag = $request->send_flag;
        $to_email = $request->to_email;
        $cc_email = explode(',', $request->cc_email);
        $analyzing_period = $request->analyzing_period;
        $comparison_flag = $request->comparison_flag;

        // toメールの更新
        $mail_setting_to = ReportSendMail::where([
            ['site_id', '=', $site_id],
            ['to_cc', '=', 0],
        ])->first();
        if ($mail_setting_to->mailaddress != $to_email) {
            $mail_setting_to->mailaddress = $to_email;
            $mail_setting_to->updated_at = date('Y-m-d H:i:s');
            $mail_setting_to->save();
        }

        // ccメールの更新
        ReportSendMail::where([
            ['site_id', '=', $site_id],
            ['to_cc', '=', 1],
        ])->delete();
        foreach ($cc_email as $key => $val) {
            $mail_setting_cc = new ReportSendMail;
            $mail_setting_cc->site_id = $site_id;
            $mail_setting_cc->mailaddress = $val;
            $mail_setting_cc->to_cc = 1;
            $mail_setting_cc->created_at = date('Y-m-d H:i:s');
            $mail_setting_cc->updated_at = date('Y-m-d H:i:s');
            $mail_setting_cc->save();
        }

        // 送信スパンの更新
        ReportSendDays::where('site_id', $site_id)->delete();
        foreach ($analyzing_period as $key => $val) {
            $send_days = new ReportSendDays;
            $send_days->site_id = $site_id;
            $send_days->days = $val;
            $send_days->created_at = date('Y-m-d H:i:s');
            $send_days->updated_at = date('Y-m-d H:i:s');
            $send_days->save();
        }

        // フラグの更新
        $site = AddSites::where('id', $site_id)->first();
        $site->send_flag = $send_flag;
        $site->comparison_flag = $comparison_flag;
        $site->updated_at = date('Y-m-d H:i:s');
        $site->save();

        return redirect(route('send-setting', $site_id))->with('message', '正しく更新されました。');
    }
}
