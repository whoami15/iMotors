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

Route::get('/', array('as' => 'get-home', 'uses' => 'HomeController@getHome'));
Route::get('/product/{slug}', array('as' => 'get-product-details', 'uses' => 'HomeController@getProductDetails'));
Route::get('/shop', array('as' => 'get-products', 'uses' => 'HomeController@getProducts'));

//Route::get('/test', function () {
//    return view('home');
//});


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
    Route::get('/application', array('as' => 'get-member-application','uses' => 'Member\MemberController@getMemberApplication'));
    Route::get('/application/history', array('as' => 'get-member-application-history','uses' => 'Member\MemberController@getMemberApplications'));
    Route::get('/member-application-history-data', array('as' => 'get-member-application-history-data','uses' => 'Member\MemberController@getMemberApplicationsData'));



    // # SUB ADMIN -- #

    Route::get('/subadmin', array('as' => 'get-subadmin-dashboard','uses' => 'Member\MemberController@getMemberDashboard'));
    Route::get('/subadmin-dashboard-data', array('as' => 'get-subadmin-dashboard-data','uses' => 'Member\MemberController@getMemberDashboardData'));



    // # ADMIN -- #

    Route::get('/admin', array('as' => 'get-admin-dashboard','uses' => 'Admin\AdminController@getAdminDashboard'));
    Route::get('/admin-dashboard-data', array('as' => 'get-admin-dashboard-data','uses' => 'Admin\AdminController@getAdminDashboardData'));

    Route::get('/admin/applications', array('as' => 'get-admin-applications','uses' => 'Admin\AdminController@getAdminApplications'));
    Route::get('/admin-applications-data', array('as' => 'get-admin-applications-data','uses' => 'Admin\AdminController@getAdminApplicationsData'));

    Route::get('/admin/products/add', array('as' => 'get-admin-add-products','uses' => 'Admin\AdminController@getAdminAddProduct'));
	Route::get('/admin/products', array('as' => 'get-admin-products','uses' => 'Admin\AdminController@getAdminProducts'));
	Route::get('/admin/products-list-data', array('as' => 'get-admin-products-data','uses' => 'Admin\AdminController@getAdminProductData'));
	Route::get('/admin/products/edit/{id}', array('as' => 'get-admin-edit-products','uses' => 'Admin\AdminController@getAdminEditProduct'));
	Route::post('/admin/products/add', array('as' => 'post-admin-add-products','uses' => 'Admin\AdminController@postAdminAddProduct'));
    Route::post('/admin/products/{id}/edit', array('as' => 'post-admin-edit-products','uses' => 'Admin\AdminController@postAdminEditProduct'));
    Route::post('/admin/brand/add', array('as' => 'post-admin-add-brand','uses' => 'Admin\AdminController@postAdminAddBrand'));
    Route::post('/admin/motor_type/add', array('as' => 'post-admin-add-motor_type','uses' => 'Admin\AdminController@postAdminAddMotorType'));
    Route::post('/admin/branch/add', array('as' => 'post-admin-add-branch','uses' => 'Admin\AdminController@postAdminAddBranch'));

});  