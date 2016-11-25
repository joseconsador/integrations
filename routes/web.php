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

Route::get('terms-and-conditions', [
    'as' => 'terms',
    'uses' => function () {
        return view('zendesk.terms');
    },
]);

Route::group(['as' => 'diagnostics::'], function () {
    Route::get('ping', ['as' => 'ping', 'uses' => 'DiagnosticsController@ping']);

    Route::get('diagnostic', ['as' => 'diagnostic', 'uses' => 'DiagnosticsController@diagnostic']);
});
