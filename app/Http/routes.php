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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

// home
Route::get('/home', 'HomeController@index');

// Accounts
Route::get('/accounts', 'AccountController@showAccounts');
Route::post('/account', 'AccountController@addAccount');
Route::get('/account/{id}', 'AccountController@editAccount');
Route::get('/account', 'AccountController@newAccount');
Route::post('/account/{id}', 'AccountController@updateAccount');
Route::get('/account/{id}/enable', 'AccountController@enableAccount');
Route::get('/account/{id}/disable', 'AccountController@disableAccount');
Route::get('/account/{id}/delete', 'AccountController@removeAccount');
Route::get('/accounts/category/{category}', 'AccountController@showAccounts');

// Groups (accounts)
Route::get('/groups', 'GroupController@showGroups');
Route::post('/groups', 'GroupController@addGroup');
Route::get('/group/{id}/delete', 'GroupController@removeGroup');
Route::get('/group/{id}/accounts', 'GroupController@showAccounts');
Route::get('/group/{id}/purge', 'GroupController@purgeAccounts');
Route::get('/group/{id}/disable', 'GroupController@disableAccounts');
Route::get('/group/{id}/accounts/category/{category}', 'GroupController@showAccounts');

// Users (app administrators)
Route::get('/administrators', 'AdminController@showUsers');
Route::get('/user', 'AdminController@newUser');
Route::get('/user/{id}', 'AdminController@editUser');
Route::post('/user', 'AdminController@addUser');
Route::post('/user/{id}', 'AdminController@updateUser');
Route::get('/user/{id}/enable', 'AdminController@enableUser');
Route::get('/user/{id}/disable', 'AdminController@disableUser');
Route::get('/user/{id}/delete', 'AdminController@removeUser');
Route::get('/profile', 'UserController@showProfile');
Route::post('/profile', 'AdminController@updateUser');

// Whitelists
Route::get('whitelist/{type}s', 'ProxyListItemController@showList');
Route::post('whitelist/{type}', 'ProxyListItemController@addItem');
Route::post('whitelist/{type}/{id}', 'ProxyListItemController@updateItem');
Route::get('whitelist/{type}/{id}/delete', 'ProxyListItemController@removeItem');
Route::get('whitelist/{type}s/clear', 'ProxyListItemController@clearList');
