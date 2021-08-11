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
}
