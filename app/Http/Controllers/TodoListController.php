<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoList;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index(){
        $lists = TodoList::all();
        return response($lists);
    }

    public function show(TodoList $todolist)
    {
//        $list = TodoList::findOrFail($todolist);
        return response($todolist);
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>['required']]);
        $list = TodoList::create($request->all());
        return response($list,Response::HTTP_CREATED);
    }

    public function destroy(TodoList $todolist)
    {
        $todolist->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }

    public function update(TodoList $todolist,Request $request)
    {
        $request->validate(['name' => ['required']]);
        $todolist->update($request->all());
        return $todolist;
    }
}
