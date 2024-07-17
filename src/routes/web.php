<?php

use App\Http\Controllers\AttendanceController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    Route::post('/start_time', [AttendanceController::class, 'startTime'])->name('start_time');
    Route::post('/end_time', [AttendanceController::class, 'endTime'])->name('end_time');
    Route::post('/rest_start', [AttendanceController::class, 'restStart'])->name('rest_start');
    Route::post('/rest_end', [AttendanceController::class, 'restEnd'])->name('rest_end');
    Route::get('/attendance', [AttendanceController::class, 'attendanceList'])->name('attendance');
});