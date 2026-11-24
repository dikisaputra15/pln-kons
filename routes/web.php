<?php

use App\Http\Controllers\DayaController;
use App\Http\Controllers\GiController;
use App\Http\Controllers\JenispekerjaanController;
use App\Http\Controllers\JenispengadaanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenyambunganController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SubjenispekerjaanController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\UidController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::get('/', fn (): RedirectResponse => redirect()->route(auth()->check() ? 'home' : 'login'));

Route::view('/home', 'home')->middleware('auth')->name('home');

Route::resource('tarifs', TarifController::class)->except('show')->middleware('auth');

Route::resource('dayas', DayaController::class)->except('show')->middleware('auth');

Route::resource('uids', UidController::class)->except('show')->middleware('auth');

Route::resource('units', UnitController::class)->except('show')->middleware('auth');

Route::resource('gis', GiController::class)->except('show')->middleware('auth');

Route::resource('jenispengadaans', JenispengadaanController::class)->except('show')->middleware('auth');

Route::resource('satuans', SatuanController::class)->except('show')->middleware('auth');

Route::resource('kategoris', KategoriController::class)->except('show')->middleware('auth');

Route::resource('penyambungans', PenyambunganController::class)->except('show')->middleware('auth');

Route::resource('jenispekerjaans', JenispekerjaanController::class)->except('show')->middleware('auth');

Route::resource('subjenispekerjaans', SubjenispekerjaanController::class)->except('show')->middleware('auth');

Route::middleware(['auth:web', RoleMiddleware::using(User::ADMIN_ROLE, 'web')])->group(function (): void {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('roles', RoleController::class)->except('show');
});
