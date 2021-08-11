<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\Request;

class ToDoListController extends Controller
{
    public function index() {
        $list_arr = ToDoList::get();
        
        return response()->json([
            'list_arr' => $list_arr
        ], 200);
    }

    public function store() {
        $validated = request()->validate([
            'title' => 'required'
        ]);                   

        $ToDoList = ToDoList::create($validated);

        return response()->json([
            'ToDoList' => $ToDoList
        ], 200);
    }


    public function complete() {        
        $ToDoList = ToDoList::find(request('ToDoId'));
        $ToDoList->completion_is = "1";
        $ToDoList->save();

        $list_arr = ToDoList::get();
        return response()->json([
            'list_arr' => $list_arr
        ], 200);
    }
}
