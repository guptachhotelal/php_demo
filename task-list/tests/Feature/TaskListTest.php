<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskListTest extends TestCase
{
    public function test_app(): void
    {
        $response = $this->get('/')
            ->assertRedirect('/tasks');
        $response->assertStatus(302);
    }

    public function test_edit_task() 
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', ['task' => $task]));
        $response->assertStatus(200)
            ->assertViewIs('edit')
            ->assertViewHas('task', $task);
    }

    public function test_create_task()
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'This is a new task description.',
            'long_description' => 'This is a new task long description.'
        ];

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->post(route('tasks.store'), $taskData);

        $response->assertStatus(Response::HTTP_FOUND);
        unset($taskData['id']);

        $this->withoutMiddleware();
        $this->post(route('tasks.store'), $taskData);
    }

    public function test_task_not_found()
    {
        $response = $this->get(route('tasks.show', ['task' => 12345]));
        $response->assertStatus(404);
    }


    public function test_invalid_title_description()
    {
        $invalidTaskData = [
            'title' => '', 
            'description' => '',
            'long_description' => ''
        ];

        $response = $this->post(route('tasks.store'), $invalidTaskData);
        $response->assertSessionHasErrors(['title', 'description']);
    }

    public function test_valid_data()
    {
        $validTaskData = [
            'title' => 'Valid Title',
            'description' => 'Valid Description',
            'long_description' => 'Valid Long Description'
        ];

        $response = $this->post(route('tasks.store'), $validTaskData);
        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_task_toggle()
    {
        $task = Task::factory()->create();

        $response = $this->put(route('tasks.toggle-complete', $task));

        $task->refresh();
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Task updated successfully!');
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Task deleted successfully!');
    }
}
