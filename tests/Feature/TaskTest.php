<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private $task;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->task = $this->createTask();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_all_tasks_of_a_todo_list()
    {
        // action
        $list = $this->createTodoList();
        $response = $this->getJson(route('todo-list.task.index',$list->id))->assertOk()->json();

        // assertion
        $this->assertEquals(1,count($response));
        $this->assertEquals($this->task->title,$response[0]['title']);
    }

    public function test_store_a_task_for_a_todo_list()
    {
        $task = Task::factory()->make();
        $list = $this->createTodoList();

        $this->postJson(route('todo-list.task.store',$list->id),['title' => $task->title])->assertCreated();

        $this->assertDatabaseHas('tasks',['title'=>$task->title]);
    }

    public function test_delete_a_task_from_database()
    {
        $this->deleteJson(route('task.destroy',$this->task->id))->assertNoContent();

        $this->assertDatabaseMissing('tasks',['title' => $this->task->title]);
    }

    public function test_update_a_task_from_a_todo_list()
    {
        $task = $this->task;

        $this->patchJson(route('task.update',$task->id),['title' => 'updated title task'])->assertOk();

        $this->assertDatabaseHas('tasks',['title' => 'updated title task']);
    }
}
