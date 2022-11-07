<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\EmployeeAccessRecordController;

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



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/change-lenguaje/{lang}', [HomeController::class, 'changeLang'])->name('change.lang');
Route::get('/get-access', [EmployeeAccessRecordController::class, 'index'])->name('index.access.record');

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('panel')->group(function () {
        Route::get('/departments', [DepartamentosController::class, 'index'])->name('index.departments');
        Route::get('/users', [UserController::class, 'index'])->name('index.users');
        Route::get('/employees', [EmployeeController::class, 'index'])->name('index.employees');
        Route::get('/employees/record/{id}', [EmployeeController::class, 'indexRecord'])->name('index.employees.record');
        Route::get('/employees/records-history', [EmployeeAccessRecordController::class, 'indexRecordHistory'])->name('index.employees.record.history');
        Route::prefix('employees/download')->group(function () {
            Route::get('/{from}.{to}.{id}', [EmployeeAccessRecordController::class, 'downloadRecord'])->name('index.employees.record.download');
            Route::get('/record-history/{from}.{to}', [EmployeeAccessRecordController::class, 'downloadRecord2'])->name('index.employees.history.download');
            Route::get('/record-history-not-found/{from}.{to}', [EmployeeAccessRecordController::class, 'downloadRecord3'])->name('index.employees.history.notfound.download');
        });
        Route::get('/setting', [SettingController::class, 'index'])->name('index.setting');
        Route::get('/rol-and-permissions', [HomeController::class, 'indexroles'])->name('index.rols');
    });
});
