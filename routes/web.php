<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminCmsRequestsController;
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
    return redirect('/admin');
});

Route::get('/admin', [DashboardController::class, 'getIndex']);
Route::get('/admin/waiting-page', [DashboardController::class, 'getWelcome'])->name('getWelcome');
Route::get('/admin/maklumat-pelayanan', [DashboardController::class, 'getMaklumatPelayanan'])->name('getMaklumatPelayanan');
Route::get('/admin/jenis-layanan', [DashboardController::class, 'getJenisLayanan'])->name('getJenisLayanan');
Route::get('/admin/tarif-pengujian', [DashboardController::class, 'getTarifPengujian'])->name('getTarifPengujian');
Route::get('/lab', [DashboardController::class, 'getLab'])->name('getLab');

Route::get(
    '/admin/requests/pay/{id}',
    [AdminCmsRequestsController::class, 'getPay']
);