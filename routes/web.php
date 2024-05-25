<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('single-page-application', [EmployeeController::class, 'index']);
Route::post('saveData', [EmployeeController::class, 'saveData'])->name('saveData');
Route::get('getData', [EmployeeController::class, 'getData'])->name('getData');
Route::post('editData', [EmployeeController::class, 'editData'])->name('editData');
Route::post('deleteData', [EmployeeController::class, 'deleteData'])->name('deleteData');

