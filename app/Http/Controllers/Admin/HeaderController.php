<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/20/2017
 * Time: 6:07 AM
 */

namespace App\Http\Controllers\Admin;


use App\Header;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class HeaderController extends Controller
{
    public function index(){
        return view('admin.header.index');
    }

    public function showAddForm(){
        return view('admin.header.add');
    }

    public function add(){
        $input = Request::all();

        Header::create($input);

        return redirect('admin/header/');
    }

    public function delete($id){
        Header::destroy($id);

        return redirect('admin/header');
    }

}