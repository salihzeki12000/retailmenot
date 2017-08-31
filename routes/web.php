<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function (){
   return view('store');
});

Route::get('/', 'HomeController@index');

Route::get('/view/store/{id}', 'ViewController@index');


Route::get('/login', function (){
    return view('login');
})->middleware('guest');




Route::get('/signup', function (){
    return view('signup');
})->middleware('guest');

Route::group(['prefix' => 'dashboard'],function () {
    Route::get('/', 'DashboardController@index');
    Route::get('/store', 'DashboardController@store');


    Route::get('/coupon', 'DashboardController@coupon');

    #store
    Route::get('/store/addForm', 'StoreController@showAddForm');

    Route::post('/store/add', 'StoreController@add');

    Route::get('/store/editForm/{id}', 'StoreController@showEditForm');

    Route::post('/store/edit/{id}', 'StoreController@edit');

    #coupon
    Route::get('/coupon/addForm', 'CouponController@showAddForm');

    Route::post('/coupon/add', 'CouponController@add');

    Route::get('/coupon/editForm/{id}', 'CouponController@showEditForm');

    Route::post('/coupon/edit/{id}', 'CouponController@edit');

});

Route::group(['namespace' => 'Auth'], function () {
    Route::post('/register', 'RegisterController@register');
    Route::post('/login', 'LoginController@login');

    Route::get('/logout', 'LoginController@logout');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/login', 'LoginController@showLoginForm');

    Route::post('/login', 'LoginController@login');

    Route::get('/logout', 'LoginController@logout');

    Route::group(['middleware' => 'auth.admin'], function (){

        Route::get('/', 'HomeController@index');

        Route::get('/category/add', 'CategoryController@showAddForm');

        Route::post('/category/add', 'CategoryController@add');

        Route::get('/category', 'CategoryController@index');

        Route::get('/category/edit/{id}', 'CategoryController@showEditForm');

        Route::post('/category/edit/{id}', 'CategoryController@edit');

        Route::get('/category/delete/{id}', 'CategoryController@delete');


        #user
        Route::get('/user', 'UserController@index');

        Route::get('/user/delete/{id}', 'UserController@delete');

        #store
        Route::get('/store', 'StoreController@index');

        Route::get('/store/add', 'StoreController@showAddForm');

        Route::post('/store/add', 'StoreController@add');

        #coupon
        Route::get('/coupon', 'CouponController@index');

        Route::get('/coupon/add', 'CouponController@showAddForm');

        Route::post('/coupon/add', 'CouponController@add');

        #header
        Route::get('/header', 'HeaderController@index');

        Route::get('/header/add', 'HeaderController@showAddForm');

        Route::post('/header/add', 'HeaderController@add');

        Route::get('/header/edit/{id}', 'HeaderController@showEditForm');

        Route::post('/header/edit/{id}', 'HeaderController@edit');

        Route::get('/header/delete/{id}', 'HeaderController@delete');


    });
});


