<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/15/2017
 * Time: 1:59 AM
 */

namespace App\Http\Controllers;


class HomeController extends Controller
{


    public function index(){
        return view('home');
    }

}