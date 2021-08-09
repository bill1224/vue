<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

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
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
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
// Route::get('user/{id}', function ($id) {
//     // Only executed if {id} is numeric...
//     return "User ID:".$id;
// });

//name 메소드를 체이닝 하여 라우트에 이름을 지정할 수 있습니다. 라우트 이름은 언제나 고유해야 합니다.
// Route::get('user/profile', function () {
//     return 'name메소드를 지정해서, route함수를 통해 리다이렉션을 생성할 때 route이름을 사용해서 왔다';
// })->name('profile');

//주어진 라우트에 대한 이름이 할당되면, 전역 route 함수를 통해서 URL 또는 리다이렉션을 생성할 때 라우트 이름을 사용할 수 있습니다.
// Route::get('routeName', function () {
//     return redirect()->route('profile');
// });

// Route::get('user/{id}/profile', function ($id) {
//     return "user id :".$id;
// })->name('profile');

//route()함수에 파라미터도 같이 보낼 수 있으며, 배열형태로 여러개의 파라미터를 전달할 수도있다. 
//이때, 기존 name()된 라우터에서 파라미터가 지정되어있지 않은  초과된 파라미터는 
//URL에 쿼리문형태로 추가되어진다. /user/1/profile?photos=yes
Route::get('routeName', function () {
    return redirect()->route('profile', ['id' => 1, 'photos' => 'yes']);
});

//라우트 그룹
//그룹을 사용하면, 라우트마다 미들웨어를 지정해주지 않아도 된다. 
// Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//         // Uses first & second middleware...
//     });

//     Route::get('user/profile', function () {
//         // Uses first & second middleware...
//     });
// });

//prefix를 이용하면, url접두사가 되는 것을 지정해줄 수 있다.
// Route::prefix('admin')->group(function () {
//     //admin/users
//     Route::get('users', function () {
//         return "USERS";
//     });
//     //admin/group
//     Route::get('group', function () {
//         return "GROUP";
//     });
// });

//name(".")을 사용하면, route의 name()을 지정할때 해당 접두사를 지정해줄 수 있다.
// Route::name('admin.')->group(function () {
//     Route::get('users', function () {
//         return "USERS";
//     })->name('users'); // = name('admin.users')

//     Route::get('group', function () {
//         return "GROUP";
//     })->name('group'); = name('admin.group')
// });

// Route::get('abc', function() {
//     return redirect()->route('admin.group');
// });

// request URI 로 부터 일치하는 ID 값을 가진 모델 인스턴스를 주입할것입니다. 
//만약 데이터베이스에서 매칭되는 모델 인스턴스를 찾을 수 없으면, 자동으로 404 HTTP response 가 생성됩니다.
// Route::get('user/{name}', function (User $user) {
//     return $user->email;
// });

//id값이 아니라 다른 컬럼으로 사용하길 원한다면, 지정해줄 수도 있다.
Route::get('api/posts/{post:slug}', function (App\Post $post) {
    return $post;
});

//대체하는 라우트가 없을 때 실행할 라우트를 정의할 수 있다. 
Route::fallback(function() {
    return view('home');
});


// Request요청의 최대치를 정할 수 있다.
//throttle() 를 사용해서 throttle(60, 1) -> 1분에 60개로 제한한다는 의미 
////User 모델에 rate_limit라는 속성이 있으먄, thrpttle(rate_limit, 1)로 동적인 제한도 가능
// Route::middleware('auth:api', 'throttle:3,1')->group(function () {
//     Route::get('/user', function () {
//         return view('home');
//     });
// });

//게스트 사용자와 인증된 사용자를 다른 Rate로 제한해줄 수 있다.
// "|" 를 기준으로 왼쪽은 게스트 Rate, 오른쪽은 인증된 사용자의 Rate
// "throttle:10|60. 1"은 1분동안 게스트는 10개의 Rate, 인증된 사용자는 60개의 Rate라는 의미
Route::middleware('throttle:5|60,1')->group(function () {
    Route::get('/test', function() {
        return "throttle 5번 제한";
    });
});