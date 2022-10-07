<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "dashboard" middleware group and "App\Http\Controllers\Dashboard" namespace.
| and "dashboard." route's alias name. Enjoy building your dashboard!
|
*/
Route::get('locale/{locale}', 'LocaleController@update')->name('locale')->where('locale', '(ar|en)');

Route::get('/', 'DashboardController@index')->name('home');

// Select All Routes.
Route::delete('delete', 'DeleteController@destroy')->name('delete.selected');
Route::delete('forceDelete', 'DeleteController@forceDelete')->name('forceDelete.selected');
Route::delete('restore', 'DeleteController@restore')->name('restore.selected');
Route::put('accept/requests', 'DeleteController@accept_all')->name('kitchens.requests.accept.selected');
Route::put('accept/sponsorRequests', 'DeleteController@acceptAllSponsors')->name('kitchenDurations.accept.selected');

// Kitchen Routes.
Route::get('trashed/kitchens', 'KitchenController@trashed')->name('kitchens.trashed');
Route::get('trashed/kitchens/{trashed_customer}', 'KitchenController@showTrashed')->name('kitchens.trashed.show');
Route::post('kitchens/{kitchen}/restore', 'KitchenController@restore')->name('kitchens.restore');
Route::delete('kitchens/{trashed_customer}/forceDelete', 'KitchenController@forceDelete')->name('kitchens.forceDelete');
Route::resource('kitchens', 'KitchenController');

// Kitchen Requests Routes
Route::get('requests', 'KitchenController@indexRequests')->name('kitchens.requests.index');
//Route::get('requests/show/{kitchen}', 'KitchenController@show')->name('kitchens.show');
Route::get('requests/show/{kitchen}', 'KitchenController@show')->name('kitchens.requests.show');
Route::put('requests/accept/{kitchen}', 'KitchenController@accept')->name('kitchens.requests.accept');


// Customers Routes.
Route::get('trashed/customers', 'CustomerController@trashed')->name('customers.trashed');
Route::get('trashed/customers/{trashed_customer}', 'CustomerController@showTrashed')->name('customers.trashed.show');
Route::post('customers/{trashed_customer}/restore', 'CustomerController@restore')->name('customers.restore');
Route::delete('customers/{trashed_customer}/forceDelete', 'CustomerController@forceDelete')->name('customers.forceDelete');
Route::resource('customers', 'CustomerController');

// Chefs Routes.
Route::get('trashed/chefs', 'ChefController@trashed')->name('chefs.trashed');
Route::get('trashed/chefs/{trashed_chef}', 'ChefController@showTrashed')->name('chefs.trashed.show');
Route::post('chefs/{trashed_chef}/restore', 'ChefController@restore')->name('chefs.restore');
Route::delete('chefs/{trashed_chef}/forceDelete', 'ChefController@forceDelete')->name('chefs.forceDelete');
Route::resource('chefs', 'ChefController');

// Admins Routes.
Route::get('trashed/admins', 'AdminController@trashed')->name('admins.trashed');
Route::get('trashed/admins/{trashed_admin}', 'AdminController@showTrashed')->name('admins.trashed.show');
Route::post('admins/{trashed_admin}/restore', 'AdminController@restore')->name('admins.restore');
Route::delete('admins/{trashed_admin}/forceDelete', 'AdminController@forceDelete')->name('admins.forceDelete');
Route::resource('admins', 'AdminController');

//// Kitchens Routes.
//Route::get('trashed/kitchens', 'KitchenController@trashed')->name('kitchens.trashed');
//Route::get('trashed/kitchens/{trashed_admin}', 'KitchenController@showTrashed')->name('kitchens.trashed.show');
//Route::post('kitchens/{trashed_admin}/restore', 'KitchenController@restore')->name('kitchens.restore');
//Route::delete('kitchens/{trashed_admin}/forceDelete', 'KitchenController@forceDelete')->name('kitchens.forceDelete');
//Route::resource('kitchens', 'KitchenController');


// Settings Routes.
Route::get('settings', 'SettingController@index')->name('settings.index');
Route::patch('settings', 'SettingController@update')->name('settings.update');
Route::get('backup/download', 'SettingController@downloadBackup')->name('backup.download');

// Feedback Routes.
Route::get('trashed/feedback', 'FeedbackController@trashed')->name('feedback.trashed');
Route::get('trashed/feedback/{trashed_feedback}', 'FeedbackController@showTrashed')->name('feedback.trashed.show');
Route::post('feedback/{trashed_feedback}/restore', 'FeedbackController@restore')->name('feedback.restore');
Route::delete('feedback/{trashed_feedback}/forceDelete', 'FeedbackController@forceDelete')->name('feedback.forceDelete');
Route::patch('feedback/read', 'FeedbackController@read')->name('feedback.read');
Route::patch('feedback/unread', 'FeedbackController@unread')->name('feedback.unread');
Route::resource('feedback', 'FeedbackController')->only('index', 'show', 'destroy');

// Category Routes
Route::get('trashed/category', 'CategoryController@trashed')->name('categories.trashed');
Route::get('trashed/category/{trashed_category}', 'CategoryController@showTrashed')->name('categories.trashed.show');
Route::post('category/{trashed_category}/restore', 'CategoryController@restore')->name('categories.restore');
Route::resource('categories', 'CategoryController');
Route::post('/categories', 'CategoryController@store')->name('categories.store');
//Route::put('/categories/{category}', 'CategoryController@update')->name('categories.update');

// kitchenSponsor Routes
Route::put('kitchenDuration/{kitchenDuration}/accept', 'KitchenSponsorController@accept')->name('kitchenDurations.accept');
Route::resource('kitchenDurations', 'KitchenSponsorController');
// kitchenSponsor Routes
Route::resource('sponsorDurations', 'SponsorDurationController');

// meals Routes
Route::get('trashed/meals', 'MealController@trashed')->name('meals.trashed');
Route::get('trashed/meals/{meal}', 'MealController@showTrashed')->name('meals.trashed.show');
Route::post('meals/{trashed_meal}/restore', 'MealController@restore')->name('meals.restore');
//Route::delete('meals/{trashed_customer}/forceDelete', 'MealController@forceDelete')->name('meals.forceDelete');
Route::resource('meals', 'MealController');
// orders Routes
Route::resource('orders', 'OrderController');
Route::resource('specialOrders', 'SpecialOrderController');
Route::resource('reports', 'ReportController');
Route::patch('report/read', 'ReportController@read')->name('reports.read');
Route::patch('report/unread', 'ReportController@unread')->name('reports.unread');

Route::post('wallet/admin/transfer/{user}', 'WalletController@transfer');
Route::post('wallet/admin/{user}', 'WalletController@adminDeposit');

Route::get('wallet/customers', 'WalletController@customerWallets')->name('wallets.customersWallet.index');
Route::get('wallet/customers/{user}', 'WalletController@show')->name('wallets.customersWallet.show');

Route::get('wallet/chefs', 'WalletController@chefWallets')->name('wallets.chefsWallet.index');
Route::get('wallet/chefs/{user}', 'WalletController@show')->name('wallets.chefsWallet.show');

Route::get('wallet/admins', 'WalletController@AdminWallets')->name('wallets.adminsWallet.index');
Route::get('wallet/admins/{user}', 'WalletController@show')->name('wallets.adminsWallet.show');

Route::get('wallet/withdrawals', 'WalletController@withdrawals')->name('wallets.withdrawals.index');
Route::get('wallet/withdrawals/{user}', 'WalletController@showCredit')->name('wallets.withdrawals.showCredit');
Route::patch('wallet/withdrawals/excel', 'WalletController@withdrew')->name('wallets.withdrawals.excel');

Route::resource('notifications', 'NotificationController');
Route::get('notification/certain', 'NotificationController@certain')->name('notifications.certain');

Route::get('deliveries','OrderController@delivery')->name('deliveries.delivery');
Route::patch('delivery/excel','OrderController@excel')->name('deliveries.excel');

// Coupons Routes.
Route::get('trashed/coupons', 'CouponController@trashed')->name('coupons.trashed');
Route::get('trashed/coupons/{trashed_coupon}', 'CouponController@showTrashed')->name('coupons.trashed.show');
Route::post('coupons/{trashed_coupon}/restore', 'CouponController@restore')->name('coupons.restore');
Route::delete('coupons/{trashed_coupon}/forceDelete', 'CouponController@forceDelete')->name('coupons.forceDelete');
Route::resource('coupons', 'CouponController');

// Cities Routes.
Route::get('trashed/cities', 'CityController@trashed')->name('cities.trashed');
Route::get('trashed/cities/{trashed_city}', 'CityController@showTrashed')->name('cities.trashed.show');
Route::post('cities/{trashed_city}/restore', 'CityController@restore')->name('cities.restore');
Route::delete('cities/{trashed_city}/forceDelete', 'CityController@forceDelete')->name('cities.forceDelete');
Route::resource('cities', 'CityController');

// Packages Routes.
Route::get('trashed/packages', 'PackageController@trashed')->name('packages.trashed');
Route::get('trashed/packages/{trashed_package}', 'PackageController@showTrashed')->name('packages.trashed.show');
Route::post('packages/{trashed_package}/restore', 'PackageController@restore')->name('packages.restore');
Route::delete('packages/{trashed_package}/forceDelete', 'PackageController@forceDelete')->name('packages.forceDelete');
Route::resource('packages', 'PackageController');

// DeliveryCompanies Routes.
Route::get('trashed/delivery_companies', 'DeliveryCompanyController@trashed')->name('delivery_companies.trashed');
Route::get('trashed/delivery_companies/{trashed_delivery_company}', 'DeliveryCompanyController@showTrashed')->name('delivery_companies.trashed.show');
Route::post('delivery_companies/{trashed_delivery_company}/restore', 'DeliveryCompanyController@restore')->name('delivery_companies.restore');
Route::delete('delivery_companies/{trashed_delivery_company}/forceDelete', 'DeliveryCompanyController@forceDelete')->name('delivery_companies.forceDelete');
Route::resource('delivery_companies', 'DeliveryCompanyController');

//
Route::resource('types', 'TypePaymentController');


/*  The routes of generated crud will set here: Don't remove this line  */
