<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/17/2017
 * Time: 4:54 PM
 */

namespace App\Http\Controllers;


use App\Coupon;
use App\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;


class CouponController extends Controller
{
    function showAddForm(){
        $store = DB::table('store')->where('user_id', Auth::user()->id)->get();

        return view('coupon.add', ['store' => $store]);
    }

    function add(Request $request)
    {
        $input = Request::all();

        Coupon::create($input);

        return redirect('dashboard/coupon/');
    }

    function showEditForm($id){
        $store = DB::table('store')->where('user_id', Auth::user()->id)->get();

        $coupon = Coupon::findOrFail($id);

        return view('coupon.edit', [ 'coupon' => $coupon, 'store' => $store ]);
    }

    function edit($id){

        $coupon = Coupon::findOrFail($id);

        $input = Input::all();

        $coupon->update($input);

        return redirect('dashboard/coupon/');
    }


}