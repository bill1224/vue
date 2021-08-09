<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//토큰으로 현재 회원정보를 가져온다
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user();
    return (new UserResource($request->user()))->response();
});

// 회원가입
Route::middleware(['guest:'.config('fortify.guard')])
    ->post('/register', [RegisteredUserController::class, 'store']);


//로그인
Route::post('/login', function(Request $request) {
    //로그인 리퀘스트
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);

    //해당하는 사용자 찾기
    $user = User::where('email', $request->email)->first();

    //로그인 실패 처리
    if(!user || !Hash::check($request->password, $user->password)){
        throw ValidationException::withMessages([
            'email' => ['이메일 혹은 비밀번호가 일치하지 않습니다.']
        ]);
    }

    //토큰 반환
    return $user->createToken($request->device_name)->plainTextToken;
});

//로그아웃 처리
Route::middleware('auth:sanctum')
    ->post('/logout', function(Request $request){

        //현재 모든 사용자의 모든 토큰을 만료시킴
        $request->user()->tokens()->delete();
        return response('토큰만료 성공', 200)
            ->header('Content-Type', 'text/plain');
    });


//API 리소스 라우트
Route::apiResource('photos', PhotoController::class);

//apiResources 메소드에 배열형태의 API 리소스 컨트롤러를 전달하여 여러개를 한번에 등록할 수 있습니다.
Route::apiResources([
    'photos' => PhotoController::class,
    'posts' => PostController::class,
]);