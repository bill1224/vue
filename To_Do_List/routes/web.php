<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoListController;

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
    return view('welcome');
});

Route::get('/todo', [ToDoListController::class, 'index']);

Route::get('/todo/detail/{id}', [ToDoListController::class, 'detail']);

Route::get('/todo/setDetail/{id}', function($id) {
    return view('SetDetail', [
        'id' => $id
    ]);    
});
