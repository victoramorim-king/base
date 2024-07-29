<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_guest_cannot_access_the_create_post_page()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function an_authenticated_user_can_access_the_create_post_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    #[Test]
    public function an_authenticated_user_can_create_a_post()
    {
        $user = User::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.'
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', $postData);
    }

    #[Test]
    public function it_shows_all_posts_on_index_page()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }
}
