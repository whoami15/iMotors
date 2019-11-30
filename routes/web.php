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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('member.dashboard');
});

// # AUTHENTICATION -- #

Route::get('/login', array('as' => 'login','uses' => 'Auth\LoginController@getLogin'));
Route::post('/login', 'Auth\LoginController@postLogin');
Route::get('/register', array('as' => 'register','uses' => 'Auth\RegisterController@getRegister'));
Route::post('/register', 'Auth\RegisterController@postRegister');
Route::post('/logout', 'Auth\LoginController@logout');


Route::group(['middleware' => 'revalidate'],function(){

    // # MEMBER -- #

    Route::get('/dashboard', array('as' => 'get-member-dashboard','uses' => 'Member\MemberController@getMemberDashboard'));
    Route::get('/member-dashboard-data', array('as' => 'get-member-dashboard-data','uses' => 'Member\MemberController@getMemberDashboardData'));
    Route::get('/application/history', array('as' => 'get-member-application-history','uses' => 'Member\MemberController@getMemberApplications'));
    Route::get('/member-application-history-data', array('as' => 'get-member-application-history-data','uses' => 'Member\MemberController@getMemberApplicationsData'));



    // # SUB ADMIN -- #

    Route::get('/subadmin', array('as' => 'get-subadmin-dashboard','uses' => 'Member\MemberController@getMemberDashboard'));
    Route::get('/subadmin-dashboard-data', array('as' => 'get-subadmin-dashboard-data','uses' => 'Member\MemberController@getMemberDashboardData'));



    // # ADMIN -- #

    Route::get('/admin', array('as' => 'get-admin-dashboard','uses' => 'Admin\AdminController@getAdminDashboard'));
    Route::get('/admin-dashboard-data', array('as' => 'get-admin-dashboard-data','uses' => 'Admin\AdminController@getAdminDashboardData'));
    
    Route::get('/admin/products/add', array('as' => 'get-admin-add-products','uses' => 'Admin\AdminController@getAddProperty'));
	Route::get('/admin/products', array('as' => 'get-admin-products','uses' => 'Admin\AdminController@getProperties'));
	Route::get('/admin/products-data', array('as' => 'get-admin-products-data','uses' => 'Admin\AdminController@getPropertiesData'));
	Route::get('/admin/products/edit/{id}', array('as' => 'get-admin-edit-products','uses' => 'Admin\AdminController@getEditProperty'));
	Route::post('/admin/products/add', array('as' => 'post-admin-add-products','uses' => 'Admin\AdminController@postAddProperty'));
	Route::post('/admin/products/{id}/edit', array('as' => 'post-admin-edit-products','uses' => 'Admin\AdminController@postEditProperty'));

});  