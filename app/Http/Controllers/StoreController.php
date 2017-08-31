<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/17/2017
 * Time: 4:53 PM
 */

namespace App\Http\Controllers;


use App\Store;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Request;

//use App\Http\Requests;

class StoreController extends Controller
{
    function showAddForm(){

        return view('store.add');
    }

    function add(\Illuminate\Http\Request $request){

        $file = $request->file('img');
        $file->move('public/image', $file->getClientOriginalName());


        $input = Request::all();

        $input['user_id'] = Auth::user()->id;
        $input['img'] = $file->getClientOriginalName();

        Store::create($input);

        return redirect('dashboard/store');
    }

    function showEditForm($id){
        $store = Store::findOrFail($id);

        return view('store.edit', ['store' => $store]);
    }

    function edit($id){

    }



}