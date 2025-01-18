<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_all_tags()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $tag = Tag::factory()->create(); // Create a dummy tag

        $response = $this->get(route('tags.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tags.index');
        $response->assertSee($tag->name);
    }

    /** @test */
    public function it_shows_the_create_tag_form()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user

        $response = $this->get(route('tags.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tags.create');
    }

    /** @test */
    public function it_creates_a_new_tag()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user

        $tagData = [
            'name' => 'Technology',
        ];

        $response = $this->post(route('tags.store'), $tagData);

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success', 'Tag created successfully.');
        $this->assertDatabaseHas('tags', $tagData);
    }

    /** @test */
    public function it_validates_tag_name_on_create()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user

        $response = $this->post(route('tags.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_shows_the_edit_tag_form()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $tag = Tag::factory()->create(); // Create a dummy tag

        $response = $this->get(route('tags.edit', $tag));

        $response->assertStatus(200);
        $response->assertViewIs('tags.edit');
        $response->assertSee($tag->name);
    }

    /** @test */
    public function it_updates_a_tag()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $tag = Tag::factory()->create(); // Create a dummy tag

        $updatedTagData = [
            'name' => 'Updated Tag Name',
        ];

        $response = $this->put(route('tags.update', $tag), $updatedTagData);

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success', 'Tag updated successfully.');
        $this->assertDatabaseHas('tags', $updatedTagData);
    }

    /** @test */
    public function it_validates_tag_name_on_update()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $tag = Tag::factory()->create(); // Create a dummy tag

        $response = $this->put(route('tags.update', $tag), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_deletes_a_tag()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $tag = Tag::factory()->create(); // Create a dummy tag

        $response = $this->delete(route('tags.destroy', $tag));

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success', 'Tag deleted successfully.');
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
