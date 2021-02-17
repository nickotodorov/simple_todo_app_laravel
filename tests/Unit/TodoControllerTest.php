<?php
declare (strict_types=1);

namespace Tests\Unit;


use App\Models\Todo;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class TodoControllerTest extends TestCase
{
    public function testIndex()
    {
        Event::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get(route('todos.index') . '?status=Completed', $this->setHeaders($user->api_token));

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getExpectedJsonItemListStructure());
    }

    public function testCreate()
    {
        Event::fake();

        $user = User::factory()->create();
        $todo = Todo::factory()->make();

        $response = $this->actingAs($user, 'api')->post(route('todos.store'), [
            'title' => $todo->title,
            'status' => $todo->status,
            'description' => $todo->description,
            'user_id' => $user->id
        ], $this->setHeaders($user->api_token));

        $response->assertStatus(201);

        $response->assertJsonStructure($this->getExpectedJsonItemStructure());
    }

    public function testUpdate()
    {
        Event::fake();

        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->put(route('todos.update', $todo->id), [
            'title' => $todo->title . $todo->id,
            'status' => $todo->status,
            'description' => $todo->description,
        ], $this->setHeaders($user->api_token));

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getExpectedJsonItemStructure());
    }

    protected function getExpectedJsonItemStructure(): array
    {
        return [
            'data' => [
                'id',
                'title',
                'description',
                'status',
            ],
        ];
    }

    protected function getExpectedJsonItemListStructure(): array
    {
        return [
            'data',
            'links',
            'meta'
        ];
    }

    protected function setHeaders(string $token): array
    {
        return [
             'Authentication: Bearer ' . $token,
             'X-Requested-With: XMLHttpRequest'
         ];
    }
}
