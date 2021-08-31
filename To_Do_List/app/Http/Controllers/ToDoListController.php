<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ToDoListController extends Controller
{
    public function index() {
        if(request('categoryStatus') == "All") {
            $list_arr = ToDoList::where('completion_is', request('currentState'))->orderBy('important_is', 'DESC')->orderBy('id', 'ASC')->paginate(5);
        } 
        
        else if(request('categoryStatus') == "important") {
            $list_arr = ToDoList::where([
                                        ['important_is', 1],
                                        ['completion_is', request('currentState')],
                                        ])->paginate(5);
        } 

        else if( in_array(request('categoryStatus'), ['매일','월','화','수','목','금','토','일'])) {
            $list_arr = ToDoList::where('pattern', request('categoryStatus'))->where('completion_is', request('currentState'))->paginate(5);
        }
        
        else{
            $list_arr = ToDoList::where([
                                    ['completion_is', request('currentState')],
                                    ['group', request('categoryStatus')],
                                    ])->orderBy('important_is', 'DESC')->paginate(5);
        }                
        
        return response()->json([
            'list_arr' => $list_arr
        ], 200);
    }

    public function store() {
        $validated = request()->validate([
            'title' => 'required',
            'group' => 'required'
        ]);                   
        
        $ToDoList = ToDoList::create($validated);
        
        if(request('group') == "All") {
            $list_arr = ToDoList::where('completion_is', request('currentState'))->orderBy('important_is', 'DESC')->paginate(5);
        } else {
            $list_arr = ToDoList::where([
                                    ['completion_is', request('currentState')],
                                    ['group', request('group')],
                                    ])->orderBy('important_is', 'DESC')->paginate(5);
        }        

        
        

        return response()->json([
            'ToDoList' => $ToDoList,
            'list_arr' => $list_arr
        ], 200);
    }


    public function complete() {        
        $ToDoList = ToDoList::find(request('ToDoId'));
        $ToDoList->completion_is = !($ToDoList->completion_is);
        $ToDoList->save();
        return;
    }

    public function detail() {        
        $todo_detail = ToDoList::where('id', request('id'))->first();
        
        return response()->json([
            'todo_detail' => $todo_detail
        ]);
    }

    public function updateDetail(Request $request) {
        $ToDoList = ToDoList::find(request('id'));
        $ToDoList->title = request('title');
        $ToDoList->description = request('description');
        $ToDoList->deadline = request('deadline');
        $ToDoList->pattern = request('pattern');
        $ToDoList->save();

        $todo_detail = ToDoList::where('id', request('id'))->first();

        return response();
    }

    public function important() {
        $ToDoList = ToDoList::find(request('id'));
        $ToDoList->important_is = !($ToDoList->important_is);
        $ToDoList->save();

        return response()->json([
            'ToDoList' => $ToDoList
        ], 200);
    }

    public function pattern() {
        $patternList = ToDoList::where('pattern', request('pattern'))->get();

        return response()->json([
            'patternList' => $patternList
        ]);
    }
}
