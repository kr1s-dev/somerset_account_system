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
Route::get('/', function () {
    return Redirect::to('auth/login');
});
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
Route::group(['middleware' => 'auth' , 'web'], function () {
    //Users routes
    Route::resource('users','user\UserController');
    Route::get('users/deactivateUser/{id}', ['as'=>'users.deactivateUser','uses' => 'user\UserController@deactivateUser']);
    Route::get('users/resetpassword/{id}', ['as'=>'users.resetpassword','uses' => 'user\UserController@resetPassword']);
    Route::resource('usertypes','usertype\UserTypeController');

    //Homeowner routes
    Route::resource('homeowners','homeownerinformation\HomeOwnerInformationController');

    //Homeowner member routes
    Route::resource('homeownermembers','homeownermember\HomeOwnerMemberController');
    Route::get('homeownermembers/create/{id}','homeownermember\HomeOwnerMemberController@create');

    //Invoice routes
    Route::resource('invoice','invoice\InvoiceController');

    //Receipt routes
    Route::resource('receipt','receipt\ReceiptController');
    Route::get('receipt/create/{id}','receipt\ReceiptController@create');

    //Expense routes
    Route::resource('expense','expense\ExpenseController');

    //Asset routes
    Route::resource('assets','assets\AssetController');

    //Announcements routes
    Route::resource('announcement','announcement\AnnouncementController');

    //Journal Entry Routes
    Route::get('journal/create' ,['as'=>'journal','uses'=>'journal\JournalEntryController@getJournalEntry']);
    Route::post('journal/create' ,'journal\JournalEntryController@postJournalEntry');
    
    //Account info routes
    Route::resource('account','accountInformation\AccountInformationController');

    //Account title routes
    Route::resource('accounttitle','accountTitle\AccountTitleController');
    Route::get('accounttitle/create/{id}','accountTitle\AccountTitleController@createWithParent');
    Route::get('accounttitle/create/group/{id}','accountTitle\AccountTitleController@createWithGroupParent');

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
    
    //Guest View
    
});
