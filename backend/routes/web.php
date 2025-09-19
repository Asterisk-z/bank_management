<?php

use Illuminate\Support\Facades\Artisan;
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
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    return view('welcome');
});

Route::get('/beatit', function () {
    Artisan::call('migrate');
    Artisan::call('db:seed');
    return view('welcome');
});

Route::get('/beatoff', function () {
    Artisan::call('migrate:fresh');
    return view('welcome');
});

Route::get('/test_mailables', function () {
    return view('mail-templete');
});

Route::get('/notify', function () {
    return view('emails.notification');
});
