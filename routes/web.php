<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('students', [StudentController::class, 'index']);
Route::get('get-all-student', [StudentController::class, 'get_all_student'])->name('students.all');
Route::get('show-student', [StudentController::class, 'show_student'])->name('students.show');
Route::post('students', [StudentController::class, 'store'])->name('students.store');
Route::put('update-student', [StudentController::class, 'update_student'])->name('students.update');
Route::delete('delete-student', [StudentController::class, 'delete_student'])->name('students.delete');

Route::get('/', function () {
    return view('welcome');
});
