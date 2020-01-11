<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\FormSendmail;
use App\Mail\FormAdminSendmail;
use App\Mail\PlanSendmail;
use App\Mail\PlanAdminSendmail;
use App\AddSites;
use App\Plans;

use Auth;

class FormController extends Controller
{
    // 退会
    public function unsubscribe_form()
    {
        $user = Auth::user();
        return view('form.unsubsc')->with([
            'user' => $user,
        ]);
    }

    public function unsubscribe_confirm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'cause' => 'required'
        ]);
        $inputs = $request->all();
        return view('form.unsubsc-confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function unsubscribe_send(Request $request)
    {
        $inputs = $request->all();
        \Mail::to($inputs['email'])->send(new FormSendmail($inputs));
        \Mail::to('kagari-unsub@kagari.ai')->send(new FormAdminSendmail($inputs));
        return view('form.unsubsc-send', [
            'inputs' => $inputs,
        ]);
    }

    // プラン変更
    public function changeplan_form(Request $request)
    {
        $user = Auth::user();
        $plan = Plans::all();
        return view('form.changeplan')->with([
            'user' => $user,
            'site_id' => $request->site_id,
            'site_url' => $request->site_url,
            'site_name' => $request->site_name,
            'site_plan' => $request->site_plan,
            'plan' => $plan
        ]);
    }

    public function changeplan_confirm(Request $request)
    {
        $inputs = $request->all();
        return view('form.changeplan-confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function changeplan_send(Request $request)
    {
        $inputs = $request->all();
        \Mail::to($inputs['email'])->send(new PlanSendmail($inputs));
        \Mail::to('kagari-changeplan@kagari.ai')->send(new PlanAdminSendmail($inputs));
        return view('form.changeplan-send', [
            'inputs' => $inputs,
        ]);
    }
}