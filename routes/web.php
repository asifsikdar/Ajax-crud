<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    return view('home');
});

Route::get('users', [HomeController::class, 'index'])->name('users.index');
Route::post('userspost', [HomeController::class, 'UserPost'])->name('users.post');
Route::get('/fetch_data', [HomeController::class, 'FetchData'])->name('users.fetch');
Route::get('/edit_student/{id}',[HomeController::class,'EditStudent'])->name('student.edit');
Route::put('/update_stu/{id}',[HomeController::class,'UpdateStudent']);
Route::delete('/delete-student/{id}',[HomeController::class,'DeleteStudent']);