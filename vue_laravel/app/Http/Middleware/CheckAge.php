<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


     // 주어진 age가 200보다 작거나 같으면 미들웨어는 HTTP 리다이렉트를 클라이언트에게 반환합니다.
     // 그렇지 않다면 HTTP 요청은 (미들웨어를 지나) 애플리케이션 안으로 계속 진행될 것입니다.(미들웨어가 "통과"를 허용하는) 
     //HTTP 요청을 애플리케이션 안으로 계속 전달하기 원한다면, 
     //$next 콜백함수에 $request인자를 넣어 호출하면 됩니다.
    public function handle(Request $request, Closure $next, $role)
    {
        //로그인 사용자가 "역할"을 가지고 있는지 확인 (인자를 받아올 수 있음)
        if (! $request->user()->hasRole($role)) {
            // Redirect...
        }

        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }

    
}
