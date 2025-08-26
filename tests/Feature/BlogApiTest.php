<?php

namespace Tests\Feature;

use App\Infrastructure\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_published_blogs(): void
    {
        Blog::factory()->published()->count(3)->create();

        $response = $this->getJson('/api/blogs');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'blogs',
                     'pagination' => ['current_page', 'per_page', 'total'],
                 ]);

        $this->assertCount(3, $response->json('blogs'));
    }
}

