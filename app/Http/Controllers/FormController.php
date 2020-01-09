<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\FormSendmail;
use App\Mail\FormAdminSendmail;

use Auth;

class FormController extends Controller
{
    public function unsubscribe_form()
    {
        $user = Auth::user();
        return view('form.unsubsc')->with([
            'user' => $user
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
}
