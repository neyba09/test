<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task_with_token()
    {
        Mail::fake();

        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $data = [
            'title' => 'New Task',
            'description' => 'Task details',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'title', 'description', 'status', 'due_date', 'created_at', 'updated_at'
            ])
            ->assertJsonFragment(['title' => 'New Task']);
    }

    public function test_user_cannot_create_task_without_token()
    {
        $data = [
            'title' => 'Unauthorized Task',
            'description' => 'Task details',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(401);
    }

    public function test_user_cannot_access_task_of_another_user()
    {
        Mail::fake();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $task = Task::factory()->for($user1)->create();
        $token = $user2->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Task not found']);
    }


    public function test_user_can_view_own_task_with_correct_structure()
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'title', 'description', 'status', 'due_date', 'created_at', 'updated_at'
                    ]
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
            ])
            ->assertJsonFragment([
                'id' => $task->id,
                'title' => $task->title,
            ]);
    }


    public function test_user_can_list_tasks_with_pagination()
    {
        $user = User::factory()->create();
        Task::factory()->count(15)->for($user)->create();

        $token = $user->createToken('api-token')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/tasks?per_page=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'title', 'description', 'status', 'due_date', 'created_at', 'updated_at'
                ]
            ],
            'links',
            'meta'
        ]);

        $this->assertCount(10, $response->json('data'));
    }
}
