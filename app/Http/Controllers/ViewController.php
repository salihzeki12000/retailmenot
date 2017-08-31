<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/27/2017
 * Time: 11:11 AM
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function index($id){
        return view('store-v2', ['id' => $id]);
    }

}