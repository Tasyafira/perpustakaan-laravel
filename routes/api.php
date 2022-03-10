<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanBukuController;
use App\Http\Controllers\DetailPeminjamanBukuController;
use App\Http\Controllers\PengembalianBukuController;
//use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
//});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify']], function ()
{
    Route::group(['middleware' => ['api.superadmin']], function()
    {
        Route::delete('/Kelas/{id}', 'KelasController@destroy');
        Route::delete('/Siswa/{id}', 'SiswaController@destroy');
        Route::delete('/Buku/{id}', 'BukuController@destroy');
        Route::delete('/PeminjamanBuku/{id}', 'PeminjamanBukuController@destroy');
        Route::delete('/PengembalianBuku/{id}', 'PengembalianBukuController@destroy');
        Route::delete('/DetailPeminjamanBuku/{id}', 'DetailPeminjamanBukuController@destroy');
    });

    Route::group(['middleware'=> ['api.admin']], function()
    {
        Route::post('/Kelas', 'KelasController@store');
        Route::put('/Kelas/{id}', 'KelasController@update');

        Route::post('/Siswa', 'SiswaController@store');
        Route::put('/Siswa/{id}', 'SiswaController@update');

        Route::post('/Buku', 'BukuController@store');
        Route::put('/Buku/{id}', 'BukuController@update');

        Route::post('/PeminjamanBuku', 'PeminjamanBukuController@store');
        Route::post('tambah_item/{id}','PeminjamanBukuController@tambahItem');
        Route::put('/PeminjamanBuku/{id}', 'PeminjamanBukuController@update');

        Route::post('/PengembalianBuku', 'PengembalianBukuController@PengembalianBuku');
        Route::put('/PengembalianBuku/{id}', 'PengembalianBukuController@update');   
        
        Route::post('/DetailPeminjamanBuku', 'DetailPeminjamanBukuController@store');
        Route::put('/DetailPeminjamanBuku/{id}', 'DetailPeminjamanBukuController@update');    
    });
        Route::get('/Kelas', 'KelasController@show');
        Route::get('/Kelas/{id}', 'KelasController@detail');

        Route::get('/Siswa', 'SiswaController@show');
        Route::get('/Siswa/{id}', 'SiswaController@detail');   
        
        Route::get('/Buku', 'BukuController@show');
        Route::get('/Buku/{id}', 'BukuController@detail');

        Route::get('/PeminjamanBuku', 'PeminjamanBukuController@show');
        Route::get('/PeminjamanBuku/{id}', 'PeminjamanBukuController@detail');  

        Route::get('/PengembalianBuku', 'PengembalianBukuController@show');
        Route::get('/PengembalianBuku/{id}', 'PengembalianBukuController@detail');

        Route::get('/DetailPeminjamanBuku', 'DetailPeminjamanBukuController@show');
        Route::get('/DetailPeminjamanBuku/{id}', 'DetailPeminjamanBukuController@detail');

});
