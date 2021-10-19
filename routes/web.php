<?php

use Illuminate\Support\Facades\Route;

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
	return view('auth.login');
});


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::post('auth', 'HomeController@auth');

Route::get('/auth', function () {
	return view('/auth');
});

Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {

	Route::group(['middleware' => ['AdminAuth']],function(){
		Route::get('home', 'AdminController@home');
		Route::post('changePassword', 'AdminController@changePassword');
		Route::post('settings', 'AdminController@settings');
		Route::get('getorder', 'AdminController@getorder');
		Route::get('clearnotification', 'AdminController@clearnotification');

		Route::get('slider', 'SliderController@index');
		Route::post('slider/store', 'SliderController@store');
		Route::get('slider/list', 'SliderController@list');
		Route::post('slider/show', 'SliderController@show');
		Route::post('slider/update', 'SliderController@update');
		Route::post('slider/destroy', 'SliderController@destroy');

		Route::get('category', 'CategoryController@index');
		Route::post('category/store', 'CategoryController@store');
		Route::get('category/list', 'CategoryController@list');
		Route::post('category/show', 'CategoryController@show');
		Route::post('category/update', 'CategoryController@update');
		Route::post('category/status', 'CategoryController@status');
		Route::post('category/delete', 'CategoryController@delete');

		Route::get('ingredients', 'IngredientsController@index');
		Route::post('ingredients/store', 'IngredientsController@store');
		Route::get('ingredients/list', 'IngredientsController@list');
		Route::post('ingredients/show', 'IngredientsController@show');
		Route::post('ingredients/update', 'IngredientsController@update');
		Route::post('ingredients/status', 'IngredientsController@status');
		Route::post('ingredients/delete', 'IngredientsController@delete');

		Route::get('item', 'ItemController@index');
		Route::get('additem', 'ItemController@additem');
		Route::get('edititem/{id}', 'ItemController@edititem');
		Route::post('item/store', 'ItemController@store');
		Route::get('item/list', 'ItemController@list');
		Route::post('item/update', 'ItemController@update');
		Route::post('item/showimage', 'ItemController@showimage');
		Route::post('item/updateimage', 'ItemController@updateimage');
		Route::post('item/storeimages', 'ItemController@storeimages');
		Route::post('item/destroyimage', 'ItemController@destroyimage');
		Route::post('item/status', 'ItemController@status');
		Route::post('item/delete', 'ItemController@delete');
		Route::post('item/deletevariation', 'ItemController@deletevariation');

		Route::get('payment', 'PaymentController@index');
		Route::post('payment/status', 'PaymentController@status');
		Route::get('manage-payment/{id}', 'PaymentController@managepayment');
		Route::post('payment/update', 'PaymentController@update');

		Route::get('addons', 'AddonsController@index');
		Route::post('addons/getitem', 'AddonsController@getitem');
		Route::post('addons/store', 'AddonsController@store');
		Route::get('addons/list', 'AddonsController@list');
		Route::post('addons/show', 'AddonsController@show');
		Route::post('addons/update', 'AddonsController@update');
		Route::post('addons/status', 'AddonsController@status');
		Route::post('addons/delete', 'AddonsController@delete');

		Route::get('users', 'UserController@index');
		Route::post('users/store', 'UserController@store');
		Route::get('users/list', 'UserController@list');
		Route::post('users/show', 'UserController@show');
		Route::post('users/update', 'UserController@update');
		Route::post('users/status', 'UserController@status');
		Route::get('user-details/{id}', 'UserController@userdetails');
		Route::post('users/addmoney', 'UserController@addmoney');
		Route::post('users/deductmoney', 'UserController@deductmoney');

		if (\App\SystemAddons::where('unique_identifier', 'otp')->first() != null && \App\SystemAddons::where('unique_identifier', 'otp')->first()->activated) {
			Route::get('orders', 'OrderotpController@index');
			Route::get('orders/list', 'OrderotpController@list');
			Route::get('invoice/{id}', 'OrderotpController@invoice');
			Route::post('orders/destroy', 'OrderotpController@destroy');
			Route::post('orders/update', 'OrderotpController@update');
			Route::post('orders/assign', 'OrderotpController@assign');
		} else {
			Route::get('orders', 'OrderController@index');
			Route::get('orders/list', 'OrderController@list');
			Route::get('invoice/{id}', 'OrderController@invoice');
			Route::post('orders/destroy', 'OrderController@destroy');
			Route::post('orders/update', 'OrderController@update');
			Route::post('orders/assign', 'OrderController@assign');
		}
		

		Route::get('reviews', 'RattingController@index');
		Route::get('reviews/list', 'RattingController@list');
		Route::post('reviews/destroy', 'RattingController@destroy');

		Route::get('promocode', 'PromocodeController@index');
		Route::post('promocode/store', 'PromocodeController@store');
		Route::get('promocode/list', 'PromocodeController@list');
		Route::post('promocode/show', 'PromocodeController@show');
		Route::post('promocode/update', 'PromocodeController@update');
		Route::post('promocode/status', 'PromocodeController@status');

		Route::get('pincode', 'PincodeController@index');
		Route::post('pincode/store', 'PincodeController@store');
		Route::get('pincode/list', 'PincodeController@list');
		Route::post('pincode/show', 'PincodeController@show');
		Route::post('pincode/update', 'PincodeController@update');
		Route::post('pincode/destroy', 'PincodeController@destroy');

		Route::get('banner', 'BannerController@index');
		Route::post('banner/store', 'BannerController@store');
		Route::get('banner/list', 'BannerController@list');
		Route::post('banner/show', 'BannerController@show');
		Route::post('banner/update', 'BannerController@update');
		Route::post('banner/destroy', 'BannerController@destroy');

		Route::get('settings', 'AboutController@index');
		Route::post('about/update', 'AboutController@update');

		Route::get('contact', 'ContactController@index');

		Route::get('driver', 'DriverController@index');
		Route::post('driver/store', 'DriverController@store');
		Route::get('driver/list', 'DriverController@list');
		Route::post('driver/show', 'DriverController@show');
		Route::post('driver/update', 'DriverController@update');
		Route::post('driver/status', 'DriverController@status');

		Route::get('branches', 'BranchController@index');
		Route::post('branches/store', 'BranchController@store');
		Route::get('branches/list', 'BranchController@list');
		Route::post('branches/show', 'BranchController@show');
		Route::post('branches/update', 'BranchController@update');
		Route::post('branches/status', 'BranchController@status');

		Route::get('report', 'ReportController@index');
		Route::get('report/list', 'ReportController@list');
		Route::post('report/show', 'ReportController@show');
		Route::post('report/destroy', 'ReportController@destroy');
		Route::post('report/update', 'ReportController@update');
		Route::post('report/assign', 'ReportController@assign');

		Route::get('time', 'TimeController@index');
		Route::post('time/store', 'TimeController@store');
		Route::get('time/list', 'TimeController@list');
		Route::post('time/show', 'TimeController@show');
		Route::post('time/update', 'TimeController@update');
		Route::post('time/destroy', 'TimeController@destroy');

		Route::get('privacypolicy', 'PrivacyPolicyController@index');
		Route::post('privacypolicy/update', 'PrivacyPolicyController@update');

		Route::get('termscondition', 'TermsController@index');
		Route::post('termscondition/update', 'TermsController@update');

		Route::get('notification', 'NotificationController@index');
		Route::post('notification/store', 'NotificationController@store');
		Route::get('notification/list', 'NotificationController@list');
		
		Route::get('clear-cache', function() {
		    Artisan::call('cache:clear');
		    return redirect()->back()->with('clear', 'Cache is cleared');
		});

		Route::get('systemaddons', 'SystemAddonsController@index');
		Route::get('createsystem-addons', 'SystemAddonsController@createsystemaddons');
		Route::post('systemaddons/store', 'SystemAddonsController@store');
		Route::get('systemaddons/list', 'SystemAddonsController@list');
		Route::post('systemaddons/update', 'SystemAddonsController@update');
	});

	Route::get('logout', 'AdminController@logout');
});

Auth::routes();


