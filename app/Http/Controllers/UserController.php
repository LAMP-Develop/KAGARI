<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AddSites;
use App\User;
use Auth;

class UserController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $add_sites = AddSites::where('user_id', $user_id)->get()->count();

        return view('auth.account', [
            'add_sites' => $add_sites,
            'user' => $user
        ]);
    }
}
