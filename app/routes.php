<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::resource('user', 'Users');

//Login
Route::get('login', array('as'=>'login', 'uses'=>'Users@login'));
Route::post('login', array('as'=>'login', 'uses'=>'Users@handleLogin'));

//Register
//Route::get('register', array('as'=>'register', 'uses'=>'UsersController@register'));
//Route::post('register', array('as'=>'register', 'uses'=>'UsersController@handleRegister'));

Route::get('/', array("as"=>"index", 'uses'=>'Home@store'));

Route::group(array('before'=>'auth'), function(){
    //Profile
    Route::any('profile', array('as'=>'profile', 'uses'=>'Users@profile'));
    //Logout
    Route::get('logout', array('as'=>'logout', 'uses'=>'Users@logout'));
    
    //Cart
    Route::get('cart', array('as'=>'cart', 'uses'=>'Cart@index'));
    Route::get('cart/add/{store}/{id}', array('as'=>'cart_add', 'uses'=>'Cart@add'));
    Route::any('cart/create', array('as'=>'cart_create', 'uses'=>'Cart@create'));
    Route::post('cart/delete/{store}/{id}', array('as'=>'cart_delete', 'uses'=>'Cart@delete'));
    
    //Store
    Route::get('staff/manage', array('as'=>'staff_manage', 'uses'=>'Staff@manage'));
    Route::get('staff/store', array('as'=>'staff_store', 'uses'=>'Staff@store'));
    Route::get('staff/item_add', array('as'=>'staff_item_add', 'uses'=>'Staff@item_add'));
    Route::get('staff/item_del', array('as'=>'staff_item_del', 'uses'=>'Staff@item_del'));
    
    //Inventory
    Route::get('staff/inventory', array('as'=>'staff_inventory', 'uses'=>'Staff@inventory'));
    Route::get('staff/edit', array('as'=>'staff_edit', 'uses'=>'Staff@edit'));
    
    //Order
    Route::get('users/orders', array('as'=>'users_orders', 'uses'=>'Users@orders'));
    Route::get('staff/orders', array('as'=>'staff_orders', 'uses'=>'Staff@orders'));
    Route::get('staff/ship', array('as'=>'staff_ship', 'uses'=>'Staff@ship'));
    
    //Sales
    Route::get('sales/statistics', array('as'=>'sales_stats', 'uses'=>'Sales@stats'));
    Route::get('sales/promotions', array('as'=>'sales_promo', 'uses'=>'Sales@promo'));
    Route::get('sales/edit', array('as'=>'sales_edit', 'uses'=>'Sales@edit'));
    
    //Bid
    Route::get('bid/add', array('as'=>'bid_add', 'uses'=>'Bids@add'));
    Route::get('staff/bids', array('as'=>'staff_bids', 'uses'=>'Staff@bids'));
    Route::get('users/bids', array('as'=>'users_bids', 'uses'=>'Users@bids'));
    Route::get('staff/auction', array('as'=>'staff_auction', 'uses'=>'Staff@auction'));
});