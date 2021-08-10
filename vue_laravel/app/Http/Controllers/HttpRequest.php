<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
