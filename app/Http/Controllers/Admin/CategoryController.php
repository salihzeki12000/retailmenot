<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/19/2017
 * Time: 4:08 PM
 */

namespace App\Http\Controllers\Admin;


use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.category.index');
    }

    public function showAddForm(){
        return view('admin.category.add');
    }

    public function add(Request $request){
        $input = Request::all();

        if (empty($input['parent_id'])){
            $input['parent_id'] = null;
        }

        //print_r($input['parent_id']);

        Category::create($input);

        return redirect('admin/category');
    }

    public function delete($id){
        Category::destroy($id);

        return redirect('admin/category');
    }

    public function showEditForm($id){
        $category = Category::findOrFail($id);

        return view('admin.category.edit', ['category' => $category, 'id' => $id]);
    }

    public function edit($id){
        $input = Request::all();

        $category = Category::findOrFail($id);

        if (empty($input['parent_id'])){
            $input['parent_id'] = null;
        }

        $category->fill($input);

        $category->save();

        return redirect('admin/category');
    }

}