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
    return redirect('home');
});
Route::get('/send/{tipe?}', 'ServiceController@send')->name('send');

Route::get('/email', function () {
    return view('email', [ 'data' => App\Models\TransOrder::first()] );
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'konfigurasi', 'namespace' => 'Konfigurasi'], function(){
        Route::post('users/grid', 'UsersController@grid');
        Route::resource('users', 'UsersController');
       
        Route::put('roles/{id}/grant', 'RolesController@grant');
        Route::post('roles/grid', 'RolesController@grid');
        Route::resource('roles', 'RolesController');
       
	});

	Route::group(['prefix' => 'master', 'namespace' => 'Master'], function(){
        Route::post('akun-induk/grid', 'AkunIndukController@grid');
        Route::get('akun-induk/perpanjang/{id}', 'AkunIndukController@perpanjang');
        Route::get('akun-induk/option', 'AkunIndukController@option');
        Route::get('akun-induk/copy/{id}', 'AkunIndukController@copy');
        Route::resource('akun-induk', 'AkunIndukController');

        Route::post('order/grid', 'OrderController@grid');
        Route::resource('order', 'OrderController');
       
        Route::post('transorder/grid', 'TransOrderController@grid');
        Route::get('transorder/copy/{id}', 'TransOrderController@copy');
        Route::resource('transorder', 'TransOrderController');

    });
    
});

       \DB::listen(function($q) {
    \Log::info($q->sql, $q->bindings);
});

Route::get('/home', 'HomeController@index')->name('home');
