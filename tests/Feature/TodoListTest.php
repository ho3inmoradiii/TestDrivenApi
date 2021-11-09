<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_all_todo_list()
    {

        // prepration / prepare
        TodoList::factory()->create();
//        TodoList::create(['name' => 'my-list']);

        // action / perform
        $response = $this->getJson(route('todo-list.index'));

        // assertion / predict
        $this->assertEquals(1,count($response->json()));
    }

    public function test_fetch_single_todo_list()
    {
        $list = TodoList::factory()->create();

        $response = $this->getJson(route('todo-list.show',$list->id))->assertOk()->json();

        $this->assertEquals($response['name'],$list->name);
    }
}
