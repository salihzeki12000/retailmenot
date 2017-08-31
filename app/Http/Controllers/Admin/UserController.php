<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/19/2017
 * Time: 10:43 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index(){
        return view('admin.user.index');
    }

    public function delete($id){
        User::destroy($id);

        return redirect('admin/user');
    }
}