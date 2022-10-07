<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group and "App\Http\Controllers\Api" namespace.
| and "api." route's alias name. Enjoy building your API!
|
*/
Route::get('get/address', function (Request $request) {
    return getAddress($request->lng , $request->lat);
});

Route::get('checktype', 'VerificationController@checktype');

Route::post('/register', 'RegisterController@register')->name('sanctum.register');
Route::post('addFcmToken', 'UsersController@addFcmToken');
Route::post('/login', 'LoginController@login')->name('sanctum.login');
Route::post('verification/restoreAccount/phone', 'VerificationController@verify_phone')->name('verification.verify_phone');
Route::post('verification/restoreAccount', 'VerificationController@restore_account')->name('verification.restore_account');
Route::post('/firebase/login', 'LoginController@firebase')->name('sanctum.login.firebase');

Route::post('/password/forget', 'ResetPasswordController@forget')->name('password.forget');
Route::post('/password/code', 'ResetPasswordController@code')->name('password.code');
Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.reset');
Route::get('/select/users', 'UserController@select')->name('users.select');

Route::post('/to_cart', 'CartController@store');
Route::delete('/to_cart/{identifier}', 'CartController@destroy');
Route::delete('/to_cart/delete/{id}', 'CartController@remove');
Route::put('/to_cart/{identifier}', 'CartController@update');
Route::get('/to_cart/{identifier}', 'CartController@show');
Route::get('/cities/list', 'CityController@index');
Route::resource('/categories', 'CategoriesController');
//
Route::get('/cart', 'CartController@get')->name('cart.show');
Route::post('/cart', 'CartController@addItem')->name('cart.add');
Route::patch('/cart', 'CartController@update')->name('cart.update');
Route::patch('/cart/{cart_item}', 'CartController@updateItem')->name('cart.update-item');
Route::delete('/cart/{cart_item}', 'CartController@deleteItem')->name('cart.delete-item');
Route::get('/cart/coutitem', 'CartController@coutitem');

//
Route::middleware('guard:sanctum')->get('kitchen/customer/show/{kitchen}', 'KitchenController@show_kitchen');
Route::middleware('guard:sanctum')->get('meal/customer/show_meal/{meal}', 'MealController@show_meal');
Route::middleware('guard:sanctum')->get('kitchens', 'KitchenController@index');
Route::get('meals/customer/list', 'MealController@list_meals');
Route::get('homescreen', 'HomeScreenController@index');
Route::get('coupon/{coupon}', 'CouponController@show');
Route::get('coupon/apply/{coupon}', 'CouponController@applyCoupon');

Route::middleware('guard:sanctum')->post('/password/verify/fb', 'VerificationController@verifyFb')->name('reset.fb');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('getPusherNotificationToken', 'LoginController@getPusherNotificationToken');
    Route::post('verification/send', 'VerificationController@send')->name('verification.send');
    Route::post('verification/verify', 'VerificationController@verify')->name('verification.verify');
    Route::get('checkphone', 'VerificationController@checkphone');

  
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::post('profile/password/change', 'ProfileController@change_password')->name('password.change');
    Route::resource('kitchens', 'KitchenController')->except('index');
    Route::get('kitchen/show', 'KitchenController@show');
    Route::get('kitchen/types', 'KitchenController@types');
    Route::put('kitchens/activation/{kitchen}', 'KitchenController@activate_kitchen');
    Route::put('kitchens/activation/special/{kitchen}', 'KitchenController@activate_special_orders');

    Route::resource('kitchens/sponsor', 'KitchenSponsorsController');
    Route::post('sponsor/approval/{kitchenSponsor}', 'KitchenSponsorsController@accept');
    Route::post('sponsor/online', 'KitchenSponsorsController@onlinePayment');
    Route::post('sponsor/extend/online', 'KitchenSponsorsController@extendOnline');
    Route::post('kitchen/extension/sponsor', 'KitchenSponsorsController@extend');
    Route::get('kitchens/sponsor/show', 'KitchenSponsorsController@show');
    Route::get('kitchens/brief/sponsor/{kitchen}', 'KitchenSponsorsController@showSummerySponsor');
    Route::get('kitchen/sponsor/durations', 'KitchenSponsorsController@indexKitchenDurations');
    Route::get('kitchen/sponsor/details/{kitchenDuration}', 'KitchenSponsorsController@sponsorshipDetails');
    Route::resource('kitchen/meals', 'MealController');
    Route::resource('durations', 'SponsorDurationsController');
    Route::get('meals/trashes', 'MealController@trash');
    Route::get('meals/sample', 'MealController@sample_show');

    Route::delete('kitchen/meals/stop/{meal}', 'MealController@stop_meal');
    Route::put('kitchen/meals/restore/{id}', 'MealController@restore_meal');

    Route::post('meal/favorite/{meal}', 'MealController@favorite');
    Route::get('meal/list/favorite', 'MealController@list_favorite');
    Route::post('kitchen/favorite/{kitchen}', 'KitchenController@favorite');
    Route::get('kitchen/list/favorite', 'KitchenController@list_favorite');

    Route::resource('/wallets', 'WalletController');
    Route::post('/recharge', 'WalletController@recharge');
    Route::post('checkout/prepare', 'WalletController@prepareCheckout')->name('checkout.prepare');
    Route::get('/wallet/sample', 'WalletController@index_sample');
    Route::post('/wallet/withdrawal', 'WalletController@withdraw');
    Route::resource('/orders', 'OrdersController');
    Route::post('online/orders', 'OrdersController@onlinePayment');
    Route::post('callEkhdemnyRequest', 'OrdersController@callEkhdemny');
    Route::post('callEkhdemnyStatus', 'OrdersController@callEkhdemny2');
//    Route::delete('/orders/chef/cancel', 'OrdersController@chef_cancel');
    Route::put('/order/accept/{order}', 'OrdersController@accept_order');
    Route::put('/order/working/{order}', 'OrdersController@working_order');
    Route::put('/order/prepared/{order}', 'OrdersController@prepare_order');
    Route::put('/order/deliver/{order}', 'OrdersController@deliver_to_order');
    Route::put('/order/receive/{order}', 'OrdersController@receive_order');
    Route::resource('/special_orders', 'SpecialOrderController');
    Route::post('online/special_orders', 'SpecialOrderController@onlinePayment');
    Route::put('/special_order/usercancel/{specialOrder}', 'SpecialOrderController@userCancel');
    Route::put('/special_order/chefcancel/{specialOrder}', 'SpecialOrderController@chefCancel');
    Route::put('/special_order/approval/{specialOrder}', 'SpecialOrderController@accept');
    Route::put('/special_order/finish/{specialOrder}', 'SpecialOrderController@finish');
    Route::resource('/reports', 'ReportController');
    Route::get('/message/{room}', 'ChatsController@show');
    Route::resource('/messages', 'ChatsController');
    Route::resource('/votes', 'VoteController');
    Route::get('/vote/meal/{meal}', 'VoteController@indexMeals');
    Route::resource('/vehicles', 'VehicleController');
    Route::put('/vehicle/activation', 'VehicleController@activate');
    Route::resource('/assigns', 'AssignOrderController');
    Route::resource('/addresses', 'AddressController');
    Route::resource('/complaints', 'ComplaintController');
    Route::resource('/notifications', 'NotificationController');
    Route::get('/notification/count', 'NotificationController@count');

    //chat
    Route::post('chat/rooms/{room}/send-message' , 'ChatController@sendMessage');
    Route::get('chat/room/{specialOrderId}' , 'ChatController@getRoomBySpecialOrder');
    Route::get('chat/rooms/{room}' , 'ChatController@getRoom');
    Route::get('chat/rooms' , 'ChatController@rooms');
    Route::get('chat/contacts/{user}' , 'ChatController@getRoomByUser');
    Route::get('chat/contacts' , 'ChatController@contacts');
    Route::get('chat/unread-rooms' , 'ChatController@getUnreadRooms');


    Route::post('password', 'VerificationController@password')->name('password.check');


    Route::match(['put', 'patch'], 'profile', 'ProfileController@update')->name('profile.update');
});
Route::post('/editor/upload', 'MediaController@editorUpload')->name('editor.upload');
Route::get('/settings', 'SettingController@index')->name('settings.index');
Route::get('/settings/terms', 'SettingController@terms')->name('settings.terms');
Route::get('/settings/pages/{page}', 'SettingController@page')
    ->where('page', 'about|terms|privacy|contacts')->name('settings.page');
Route::get('/settings/contacts', 'SettingController@contacts');

Route::post('feedback', 'FeedbackController@store')->name('feedback.send');
// Cities Routes.
Route::apiResource('cities', 'CityController');
Route::get('/select/cities', 'CityController@select')->name('cities.select');

// Packages Routes.
Route::apiResource('packages', 'PackageController');
Route::get('/select/packages', 'PackageController@select')->name('packages.select');

// DeliveryCompanies Routes.
Route::apiResource('delivery_companies', 'DeliveryCompanyController');
Route::get('/select/delivery_companies', 'DeliveryCompanyController@select')->name('delivery_companies.select');

/*  The routes of generated crud will set here: Don't remove this line  */
