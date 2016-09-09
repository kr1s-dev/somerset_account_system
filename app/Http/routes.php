<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Route for login page
// Route::get('/', function () {
//     //return Redirect::to('auth/login');
//     return view('somerset_page.index');
// });
Route::get('/', 'portal\SomersetPortalController@getPortal');
// Authentication routes...
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/login', ['as'=>'login','uses'=>'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as'=>'logout','uses' => 'Auth\AuthController@getLogout']);
//Verification of newly created user
Route::get('auth/verify/{token}', ['as'=>'verify','uses' => 'registerverifier\RegisterVerifierController@getVerifier']);
Route::post('auth/verify', ['as'=>'verify','uses' => 'registerverifier\RegisterVerifierController@postVerifier']);

// Password reset link request routes...
Route::get('password/email', ['as'=>'resetpassword','uses'=>'Auth\PasswordController@getEmail']);
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}','Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Uses authentication middleware, to avoid uneccessary access if not login
Route::group(['middleware' => 'auth'], function () {
    //Users Routes
    Route::resource('users','user\UserController');
    Route::get('users/deactivateUser/{id}', ['as'=>'users.deactivateUser','uses' => 'user\UserController@deactivateUser']);
    Route::get('users/resetpassword/{id}', ['as'=>'users.resetpassword','uses' => 'user\UserController@resetPassword']);
    Route::get('users/changepassword/{id}', ['as'=>'users.changepassword','uses' => 'user\UserController@getChangePassword']);
    Route::post('users/changepassword', 'user\UserController@postChangePassword');
    //Route::resource('usertypes','usertype\UserTypeController');

    //Homeowner routes
    Route::resource('homeowners','homeownerinformation\HomeOwnerInformationController',['except'=>['destory']]);

    //Homeowner member routes
    Route::resource('homeownermembers','homeownermember\HomeOwnerMemberController',['except'=>['index','show']]);
    Route::get('homeownermembers/create/{id}','homeownermember\HomeOwnerMemberController@create');

    //Invoice routes
    Route::resource('invoice','invoice\InvoiceController');

    //Receipt routes
    Route::resource('receipt','receipt\ReceiptController',['except'=>['edit','update','destroy']]);
    Route::get('receipt/create/{id}','receipt\ReceiptController@create');
    Route::get('receipt/create/{id}/penalty',['as'=>'create.penalty','uses'=>'receipt\ReceiptController@createPenaltyReceipt']);

    //Expense routes
    Route::resource('vendor','vendor\VendorController');

    //Expense routes
    Route::resource('expense','expense\ExpenseController');
    Route::get('expense/delete/{id}',['as'=>'expense.delete' ,'uses'=>'expense\ExpenseController@destroy']);
    Route::post('expense/delete/{id}','expense\ExpenseController@destroy');

    //Asset routes
    Route::resource('assets','assets\AssetController');

    //Announcements routes
    Route::resource('announcement','announcement\AnnouncementController');

    //Settings routes
    Route::resource('settings','settings\SettingsController',['except' => ['index', 'edit', 'destroy']]);

    //Journal Entry Routes
    Route::get('journal/create' ,['as'=>'journal','uses'=>'journal\JournalEntryController@getJournalEntry']);
    Route::post('journal/create' ,'journal\JournalEntryController@postJournalEntry');
    Route::get('adjusment/journal/create' ,['as'=>'adjustment.journal','uses'=>'journal\JournalEntryController@getAdjustmenstEntry']);
    Route::get('accounting/closed',['as'=>'close.accounting','uses'=>'accountInformation\AccountInformationController@closeAccountingYear']);
    
    
    //Account info routes
    Route::resource('account','accountInformation\AccountInformationController',['only' => ['index']]);

    //Account title routes
    Route::resource('accounttitle','accountTitle\AccountTitleController',['except'=>['destory']]);
    Route::get('accounttitle/create/{id}','accountTitle\AccountTitleController@createWithParent');
    Route::get('accounttitle/create/group/{id}','accountTitle\AccountTitleController@createWithGroupParent');

    Route::resource('item','items\InvoiceExpenseItemsController',['except'=>['index','destory']]);
    Route::get('accounttitle/item/create/{id}','items\InvoiceExpenseItemsController@create');

    //PDF Generation
    Route::post('pdf','pdf\PDFGeneratorController@postGeneratePDF');

    //Report viewing
    Route::get('reports/incomestatement',['as'=>'incomestatement','uses'=>'reports\ReportController@getGenerateIncomeStatement']);
    Route::post('reports/incomestatement','reports\ReportController@postGenerateIncomeStatement');
    Route::get('reports/ownersequitystatement',['as'=>'ownersequity','uses'=>'reports\ReportController@getGenerateOwnersEquityStatement']);
    Route::post('reports/ownersequitystatement','reports\ReportController@postGenerateOwnersEquityStatement');
    Route::get('reports/balancesheet',['as'=>'balancesheet','uses'=>'reports\ReportController@getGenerateBalanceSheet']);
    Route::post('reports/balancesheet','reports\ReportController@postGenerateBalanceSheet');
    Route::get('reports/subledger/{type}',['as'=>'subledger','uses'=>'reports\ReportController@getGenerateSubsidiaryLedger']);
    Route::post('reports/subledger','reports\ReportController@postGenerateSubsidiaryLedger');
    Route::get('reports/assets',['as'=>'asset.registry','uses'=>'reports\ReportController@getGenerateAssetRegistry']);
    Route::get('reports/cashflow',['as'=>'cash.flow','uses'=>'reports\ReportController@getGenerateStatementOfCashFlow']);

    //DashBoard View
    Route::get('admin-dashboard',['as'=>'admin.dashboard','uses'=>'admin\AdminDashboardController@getDashBoard']);
    Route::post('admin-dashboard','admin\AdminDashboardController@postDashboard');
    
    //Guest View
    Route::get('guest-dashboard',['as'=>'guestdashboard','uses'=>'guest\GuestController@getDashBoard']);
    Route::get('guest-pending-payments',['as'=>'guestpendingpayments','uses'=>'guest\GuestController@getHomeOwnerPendingPayments']);
    Route::get('guest-transaction-history',['as'=>'guesttransactionhistory','uses'=>'guest\GuestController@getTransactionHistory']);
    Route::get('guest-invoice/{id}',['as'=>'guestinvoice','uses'=>'invoice\InvoiceController@show']);
    Route::get('guest-announcement/{id}',['as'=>'guestannouncement','uses'=>'announcement\AnnouncementController@show']);

    Route::get('somerset-map', ['as'=>'map.somerset','uses' => 'maps\MapController@getMap']);
});