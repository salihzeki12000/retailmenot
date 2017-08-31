<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/17/2017
 * Time: 12:14 PM
 */

namespace App\Http\Controllers;


use App\Coupon;
use App\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');
    }

    public function index(){

    }

    public function store(){

        $list = DB::table('store')->where('user_id', '=', Auth::user()->id)->get();

        return view('store.index', ['list' => $list]);
    }

    public function coupon(){

        $list = DB::table('coupon')
            ->join('store', 'coupon.store_id', '=', 'store.id')
            ->where('store.user_id', '=', Auth::user()->id)
            ->get(['coupon.*']);
        return view('coupon.index', ['list' => $list]);
    }

}