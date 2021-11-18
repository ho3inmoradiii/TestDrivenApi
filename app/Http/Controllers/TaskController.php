<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TodoList;

class TaskController extends Controller
{
    public function index(TodoList $todoList){
        $tasks = $todoList->tasks;
        return response($tasks);
    }

    public function store(Request $request,TodoList $todo_list)
    {
        $task = $todo_list->tasks()->create($request->only('title'));
//        $request['todo_list_id'] = $todo_list->id;
//        $task = Task::create($request->only('title','todo_list_id'));
        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }

    public function update(Task $task,Request $request)
    {
        $task->update($request->only('title','status'));
        return $task;
    }
}
