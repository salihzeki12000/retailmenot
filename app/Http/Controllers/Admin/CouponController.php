<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/20/2017
 * Time: 5:18 AM
 */

namespace App\Http\Controllers\Admin;


use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class CouponController extends Controller
{

    public function index(){
        return view('admin.coupon.index');
    }

    public function showAddForm(){
        return view('admin.coupon.add');
    }

    public function add(){
        $input = Request::all();

        Coupon::create($input);

        return redirect('admin/coupon/');
    }

}