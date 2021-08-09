<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowProfile extends Controller
{
    //단일 액션만을 처리하는 컨트롤러를 정의하고 싶다면 컨트롤러에 하나의 __invoke 메소드를 넣을 수 있습니다.
    public function __invoke($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
