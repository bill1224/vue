<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index() {
        // DB::transaction(function () {
        //     DB::table('databases')->delete();
        // });

        // return view('Database');

        // $Datas = DB::table('databases')->get();

        $Datas = DB::table('databases')->find(3);

        //한개의 컬럼의 값들을 포함하고 있는 컬렉션을 조회하고자 할 경우 pluck사용
        //모든 레콛드에서 user속성 값만 가져온다.
        $Datas = DB::table('databases')->pluck('user');


        //데이터베이스 레코드가 많은 작업을 수행해야 한다면, chunk 메소드를 사용
        //-> 청킹 중 레코드를 업데이트 할 때는 항상 chunkById 메소드를 사용하는 것이 좋습니다.
        //databases테이블에서 number속성 값이 3보다 작은 레코드들
        DB::table('databases')->where('number', '<' , 3)
        ->chunkById(100, function ($datas) { //100은 테이블에서 한번에 가져올 레코드 수 
            foreach ($datas as $data) { 
                DB::table('databases')
                    ->where('id', $data->id)
                    ->update(['number' => 100]); //위에서 가져온 레코드들(number가 3보다 작은 레코드들)의 number 속성을 100으로 변환
            }
        });

        //집계함수들 다 사용할 수 있음 count, sum, max, min, avg
        $count = DB::table('databases')->count();

        //해당 조건을 만족하는 레코드가 존재하면 1 출력, 없으면 null
        // $Datas = DB::table('databases')->where('id', 2)->exists();
        //해당 조건을 만족하는 레코드가 존재하면 null, 없으면 1
        // $Datas = DB::table('databases')->where('id', 1)->doesntExist();

        //select를 이용해서 원하는 컬럼만 
        $Datas = DB::table('databases')->select('user', 'number')->get();
        //distinct를 사용하면 속성값이 중복된 것은 제외
        // $users = DB::table('users')->distinct()->get();

        //이미 쿼리빌더 인스턴스를 가지고 있고, 존재하는 select 구문에 선택할 컬럼을 추가하고자 한다면, addSelect 메소드를 사용할 수 있습니다.
        // $query = DB::table('users')->select('name');
        // $users = $query->addSelect('age')->get();   


        //때로는, 쿼리에서 Raw Expressions를 사용하고자 할 수도 있습니다. raw expression 을 생성하기 위해서는 DB::raw 메소드를 사용할 수 있습니다.
        // $users = DB::table('users')
        //              ->select(DB::raw('count(*) as user_count, status'))
        //              ->where('status', '<>', 1)
        //              ->groupBy('status')
        //              ->get();

        //DB::raw를 간단히 selectRaw로 사용가능 
        // $orders = DB::table('orders')
        //         ->selectRaw('price * ? as price_with_tax', [1.0825])
        //         ->get();

        //whereRaw 와 orWhereRaw 메소드는 쿼리의 where 절에 raw 한 구문을 삽입하는데 사용할 수 있습니다. 이 메소드도 옵션 배열을 두번째 인자로 받습니다.
        // $orders = DB::table('orders')
        //         ->whereRaw('price > IF(state = "TX", ?, 100)', [200])
        //         ->get();


        //join 메소드에 전달되는 첫번째 인자는 join을 수행할 테이블의 이름이며, 구 이후는 join 을 실행할 때 컬럼의 제약 조건입니다.
        // $users = DB::table('users')
        //     ->join('contacts', 'users.id', '=', 'contacts.user_id')
        //     ->join('orders', 'users.id', '=', 'orders.user_id')
        //     ->select('users.*', 'contacts.phone', 'orders.price')
        //     ->get();

        //좀 더 복잡한 join
        //join 메소드의 두번째 인자로 Closure 를 전달하십시오. Closure 는 JoinCaluse 객체를 전달 받아, join 구문에 제약사항을 지정할 것입니다.
        // DB::table('users')
        // ->join('contacts', function ($join) {
        //     $join->on('users.id', '=', 'contacts.user_id')
        //          ->where('contacts.user_id', '>', 5);
        // })
        // ->get();


        //Where절
        //아래처럼 =일때는 생략가능
        // $users = DB::table('users')->where('votes', '=', 100)->get();
        // $users = DB::table('users')->where('votes', 100)->get();

        // $users = DB::table('users')
        //         ->where('votes', '>=', 100)
        //         ->get();

        // $users = DB::table('users')
        //                 ->where('votes', '<>', 100)
        //                 ->get();

        // $users = DB::table('users')
        //                 ->where('name', 'like', 'T%')
        //                 ->get();

        //where은 배열로 보내는 것도 가능
        // $users = DB::table('users')->where([
        //     ['status', '=', '1'],
        //     ['subscribed', '<>', '1'],
        // ])->get();

        //or구문
        // $users = DB::table('users')
        //             ->where('votes', '>', 100)
        //             ->orWhere('name', 'John')
        //             ->get();
        
        //괄호 안에 "or"조건을 그룹화해야하는 경우 orWhere 메소드의 첫 번째 인수로 클로저를 전달할 수 있습니다.
        // $users = DB::table('users')
        // ->where('votes', '>', 100)
        // ->orWhere(function($query) {
        //     $query->where('name', 'Abigail')
        //           ->where('votes', '>', 50);
        // })
        // ->get();


        //between
        // $users = DB::table('users')
        //    ->whereBetween('votes', [1, 100])
        //    ->get();

        //Not Between
        // $users = DB::table('users')
        //             ->whereNotBetween('votes', [1, 100])
        //             ->get();

        
        //whereIn 주어진 배열안에 속하는지 
        // $users = DB::table('users')
        //             ->whereIn('id', [1, 2, 3])
        //             ->get();


        return view('Database', [
            'Datas' => $Datas,
            'count' => $count,
        ]);
    }
}
