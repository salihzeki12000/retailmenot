<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/20/2017
 * Time: 5:17 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Store;
use Illuminate\Support\Facades\Request;

class StoreController extends Controller
{
    public function index(){
        return view('admin.store.index');
    }

    public function showAddForm(){
        return view('admin.store.add');
    }

    public function add(\Illuminate\Http\Request $request){

        $file = $request->file('img');
        $file->move('public/image', $file->getClientOriginalName());


        $input = Request::all();

        $input['user_id'] = 0;
        $input['img'] = $file->getClientOriginalName();

        Store::create($input);

        return redirect('admin/store');
    }

}