<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_posts_for_authenticated_user()
    {
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

        // Acting as the authenticated user
        $this->actingAs($user);

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts', $posts);
    }

    /** @test */
    public function it_shows_create_post_form_with_categories_and_tags()
    {
        $user = User::factory()->create();
        $categories = Category::factory()->count(3)->create();
        $tags = Tag::factory()->count(3)->create();

        // Acting as the authenticated user
        $this->actingAs($user);

        $response = $this->get(route('posts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
        $response->assertViewHas('categories', $categories);
        $response->assertViewHas('tags', $tags);
    }

    /** @test */
    public function it_stores_a_new_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $postData = [
            'title' => 'New Post Title',
            'content' => 'Content for the post.',
            'status' => 'published',
            'category_ids' => [$category->id],
            'tag_ids' => [$tag->id],
        ];

        $this->actingAs($user);

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post created successfully.');

        $this->assertDatabaseHas('posts', ['title' => 'New Post Title']);
        $this->assertDatabaseHas('category_post', ['post_id' => 1, 'category_id' => $category->id]);
        $this->assertDatabaseHas('post_tag', ['post_id' => 1, 'tag_id' => $tag->id]);
    }

    /** @test */
    public function it_updates_an_existing_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $updateData = [
            'title' => 'Updated Post Title',
            'content' => 'Updated content for the post.',
            'status' => 'published',
            'category_ids' => [$category->id],
            'tag_ids' => [$tag->id],
        ];

        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post), $updateData);

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post updated successfully.');

        $this->assertDatabaseHas('posts', ['title' => 'Updated Post Title']);
        $this->assertDatabaseHas('category_post', ['post_id' => $post->id, 'category_id' => $category->id]);
        $this->assertDatabaseHas('post_tag', ['post_id' => $post->id, 'tag_id' => $tag->id]);
    }

    /** @test */
    public function it_deletes_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post deleted successfully.');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function it_approves_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'approval_status' => 'pending']);

        $this->actingAs($user);

        $response = $this->post(route('posts.approve', $post));

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post approved successfully.');

        $post->refresh();
        $this->assertEquals('approved', $post->approval_status);
    }

    /** @test */
    public function it_disapproves_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'approval_status' => 'approved']);

        $this->actingAs($user);

        $response = $this->post(route('posts.disapprove', $post));

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post disapproved successfully.');

        $post->refresh();
        $this->assertEquals('pending', $post->approval_status);
    }

    /** @test */
    public function it_shows_only_published_and_approved_posts()
    {
        $user = User::factory()->create();
        $approvedPost = Post::factory()->create(['user_id' => $user->id, 'status' => 'published', 'approval_status' => 'approved']);
        $pendingPost = Post::factory()->create(['user_id' => $user->id, 'status' => 'published', 'approval_status' => 'pending']);
        
        $this->actingAs($user);

        $response = $this->get(route('posts.list'));

        $response->assertStatus(200);
        $response->assertSee($approvedPost->title);
        $response->assertDontSee($pendingPost->title);
    }
}
