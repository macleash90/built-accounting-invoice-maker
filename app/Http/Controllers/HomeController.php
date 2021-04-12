<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //conditional aggregates
        //https://reinink.ca/articles/calculating-totals-in-laravel-using-conditional-aggregates
        $total_users = DB::table('users')
        ->selectRaw('count(*) as total_users')
        ->selectRaw("count(case when is_active = 1 then 1 end) as active_users")
        ->selectRaw("count(case when is_active = 0 then 1 end) as disabled_users")
        ->first();

        $total_invoices = Invoice::count();

        return view('home',compact("total_users","total_invoices"));
    }
}
