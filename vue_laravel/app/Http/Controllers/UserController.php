<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Router에서 middleware을 지정해줄 수도 있지만, controller에서 지정하는 것이
    //더 유연하게 사용할 수 있다.
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('log')->only('index');

        $this->middleware('subscribed')->except('store');
    }


    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
