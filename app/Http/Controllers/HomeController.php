<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AddSites;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $login_user_id = Auth::user()->id;
        $add_sites = AddSites::where('user_id', $login_user_id)->get();
        return view('dashboard', [
            'add_sites' => $add_sites
        ]);
    }

    public function top()
    {
        return redirect('/dashboard');
    }
}
