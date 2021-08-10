<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HttpRequest extends Controller
{
    //path()는 request의 경로정보를 반환
    //http://domain.com/foo/bar 일경우에는 foo/bar를 반환한다.
    public function path(Request $request){
        $url = $request->path();

        return view('home', [
            'url' => $url
        ]);
    }

    //is는 request가 특정 패턴에 상응하는 것을 확인할 수 있게 해준다. 
    // * 사용 가능 
    public function path_is(Request $request){
        $result = "http로 시작하는 path가 아닙니다.";

        if($request->is('http/*')){
            $result = "http로 시작하는 path가 맞습니다.";
        }
        return view('home', [
            'result' => $result
        ]);
    }

    //url()은 path()와 다르게 request url을 전부 불러온다. (쿼리 스트링은 포함 x)
    //fullurl()은 URL에 포함된 쿼리 스트링까지 전부 반환한다. 
    public function url(Request $request){
        $url = $request -> url();
        $fullurl = $request -> fullurl();
        return view('home', [
            'url' => $url,
            'fullurl' => $fullurl
        ]);
    }

    //method 메소드는 request에 대해 HTTP 메소드를 반환한다.
    //isMethod()는 특정 문자열에 대응하는 것인지 확인할 때 사용가능 ex) if ($request->isMethod('post)) {}
    public function method(Request $request){
        $method = $request->method();

        if ($request->isMethod('post')) {
            $method = 'post';
        }

        return view('home', [
            'method' => $method
        ]);
    }


    //all 메소드를 사용하여 모든 입력데이터를 배열로 조회할 수 있습니다
    //http?id=3&name=dsfsdf -> ["id" => "3", "name" => "dsfsdf"]
    public function all(Request $request){
        $input = $request->all();

        dd($input);
        return view('home', [
            'input' => $input
        ]);
    }

    //HTTP verb에 관계없이 input 메소드는 사용자 입력을 조회하는데 사용됩니다.
    //또한 input은 json배열에도 접근가능하다. 
    public function input(Request $request){
        $name = $request->input('id');
        //값이 존재하지 않을 경우에는 초기화해주는 것도 가능 
        $name = $request->input('name', 'Sally');

        //배열 입력을 가진 폼에서 동작할 때에는, 배열에 접근하기 위하여 "점" 표기법을 사용할 수 있습니다.
        $name = $request->input('products.0.name');
        $names = $request->input('products.*.name');

        //인자없이 input을 사용하면, all처럼 배열로 값을 받아온다. 
        $input = $request->input();
        dd($name);
        return view('home', [
            'name' => $name
        ]);
    }

    public function query(Request $request){
        $name = $request->query('name');
        //값이 존재하지 않을 경우에는 초기화해주는 것도 가능 
        $name = $request->query('name', 'Helen');

        //인자없이 query 사용하면, (all/input)처럼 배열로 값을 받아온다. 
        $query = $request->query();

        dd($name);
        return view('home', [
            'name' => $name
        ]);
    }

    //boolean()는 1, "1", true, "true", "on", "yes"에 대해 true를 리턴, 나머지는 false
    public function boolean(Request $request){
        $archived = $request->boolean('archived');

        dd($archived);
        return view('home', [
            'name' => $name
        ]);
    }

    //입력 데이터의 일부분만 조회하기 위해서 only와 except 메소드를 사용할 수 있습니다.
    public function onlyAndExcept(Request $request){
        $input = $request->only(['credit_card']);

        // $input = $request->only('username', 'password');

        // $input = $request->except(['credit_card']);

        // $input = $request->except('credit_card');

        dd($input);
        return view('home', [
            'name' => $name
        ]);
    }

    //has 메소드는 현재 request 에서 값이 존재할 때 true를 반환합니다.
    public function has(Request $request){
        // $has = $request->has('name');

        //배열형태일때는 배열에 있는 key값 모두가 존재해야 true
        // $has = $request->has(['name', 'email']);
        
        //hasAny 메소드는 하나라도 존재하면 true
        // $hasAny = $request->hasAny(['name', 'email']);

        //주어진 변수값이 현재 request 에 존재하고 비어 있지 않은 것을 확인하려면 filled 메소드를 사용하면 됩니다.
        // $filled = $request->filled('name');

        //주어진 키가 request 에 없는지 확인하려면 missing 메소드를 사용할 수 있습니다.
        $missing = $request->missing('name');
        dd($missing);
        return view('home', [
            'name' => $name
        ]);
    }

    //flash 메소드는 현재의 입력들을 세션에 저장하여, 
    //사용자의 다음 request 동안에도 값을 사용할 수 있게 해줍니다.
    //flashOnly와 flashExcept 메소드를 이용하여 request 데이터의 일부분을 
    //세션에 임시 저장(flash)할 수 있습니다
    public function flash(Request $request){
        $request->flash();
        $request->flashOnly(['username', 'email']);
        $request->flashExcept('password');

        dd($input);
        return view('home', [
            'name' => $name
        ]);
    }

    // 종종 입력값을 세션에 임시 저장 하고 이전 페이지로 리다이렉트 하기를 원할 수 있는데,
    // withInput 메소드를 이용하여 리다이렉트시 입력값 임시 저장이 되도록 간단하게 메소드 체이닝할 수 있습니다.
    public function withInput(Request $request){
        return redirect('form')->withInput();

        return redirect('form')->withInput(
            $request->except('password')
        );
    }

    //이전 request 에서 저장된 입력값을 조회하기 위해서는 
    //Request 인스턴스의 old 메소드를 사용하면 됩니다.
    // old 메소드는 세션에 저장된 입력 데이터를 꺼낼 것입니다.
    public function old(Request $request){
        $username = $request->old('username');
        //라라벨은 글로벌 old 헬퍼 함수도 제공합니다. 
        //블레이드 템플릿 안에서 지난 입력값을 보여주려면 old 헬퍼 함수를 사용하는 것이 보다
        // 편리합니다. 주어진 필드에 대한 이전 입력값이 존재하지 않는다면, 
        //null 이 반환될 것입니다.
        //<input type="text" name="username" value="{{ old('username') }}">
    }

    //cookie 메소드는 . Request에서 쿠키 값을 가져오기 위해서 사용
    public function cookie(Request $request){
        // $value = $request->cookie();


        //쿠키에 엑세스 하기 위해서 Cookie 파사드를 사용할 수 있습니다.
        //use Illuminate\Support\Facades\Cookie;
        $value = Cookie::get('XSRF-TOKEN');

        dd($value);
    }


}
