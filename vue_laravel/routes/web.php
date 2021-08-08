<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


// Route::middleware(['auth:sanctum', 'verified'])
//     ->get('/home', [HomeController::class, 'index']);

// Route::middleware(['auth:sanctum', 'verified'])
//     ->get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register')
//     ]);
// })->name('home');


// Route::redirect('/here', '/there', 301);

Route::view('/home', 'home', ['name' => 'jongin']);

//필수 파라미터
Route::get('/home/{id}', function(Request $request) {
    return view('home', ['id' => $request->id]);
});

// Route::get('user/{id}', function ($id) {
//     return 'User '.$id;
// });

//선택적 파라미터, ?를 붙히게되면, 파라미터가 없을 경우에도 에러가 나지 않음 
// Route::get('user/{name?}', function ($name = 'jongin') {
//     return $name;
// });


//where이용해서 파라미터의 포멧을 제한할 수 있다.
//where에는 정규식을 넣어줄 수 있음 ex) [A-Za-z]+, [0-9]+
//또한 ['id' => '[0-9]+', 'name' => '[a-z]+'] 으로 복수개의 파라미터를 정의할 수 있음
// Route::get('user/{id}', function ($id) {
//     return 'User ID :'.$id;
// })->where('id', '[0-9]+');

//RouteServiceProvider.php의 boot()안에 pattern()를 사용하면, Route에서 따로 where로 지정하지 않아도,
//항상 적용되는 포멧을 정의할 수 있다. 
//Route::pattern('id', '[0-9]+'); 을 지정하면, 항상 id 파라미터를 받을 경우에는 해당 정규식이 적용이 된다.
Route::get('user/{id}', function ($id) {
    // Only executed if {id} is numeric...
    return "User ID:".$id;
});