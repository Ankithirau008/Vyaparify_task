<?php


namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_all_categories()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $category = Category::factory()->create(); // Create a dummy category

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
        $response->assertSee($category->name);
    }

    /** @test */
    public function it_shows_the_create_category_form()
    {
        $response = $this->get(route('categories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.create');
    }

    /** @test */
    public function it_creates_a_new_category()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user

        $categoryData = [
            'name' => 'Technology',
        ];

        $response = $this->post(route('categories.store'), $categoryData);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category created successfully.');
        $this->assertDatabaseHas('categories', $categoryData);
    }

    /** @test */
    public function it_validates_category_name_on_create()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user

        $response = $this->post(route('categories.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_shows_the_edit_category_form()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $category = Category::factory()->create(); // Create a dummy category

        $response = $this->get(route('categories.edit', $category));

        $response->assertStatus(200);
        $response->assertViewIs('categories.edit');
        $response->assertSee($category->name);
    }

    /** @test */
    public function it_updates_a_category()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $category = Category::factory()->create(); // Create a dummy category

        $updatedCategoryData = [
            'name' => 'Updated Category Name',
        ];

        $response = $this->put(route('categories.update', $category), $updatedCategoryData);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category updated successfully.');
        $this->assertDatabaseHas('categories', $updatedCategoryData);
    }

    /** @test */
    public function it_validates_category_name_on_update()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $category = Category::factory()->create(); // Create a dummy category

        $response = $this->put(route('categories.update', $category), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_deletes_a_category()
    {
        $user = $this->actingAs(User::factory()->create()); // Acting as a logged-in user
        $category = Category::factory()->create(); // Create a dummy category

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category deleted successfully.');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
