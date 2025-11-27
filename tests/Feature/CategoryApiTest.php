<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_a_category()
    {
        $categoryData = [
            'name' => 'New Category',
            'slug' => 'new-category',
        ];

        $response = $this->postJson('/api/categories', $categoryData);

        $response->assertStatus(201)
            ->assertJsonFragment($categoryData);

        $this->assertDatabaseHas('categories', $categoryData);
    }

    public function test_can_get_a_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson('/api/categories/' . $category->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name]);
    }

    public function test_can_update_a_category()
    {
        $category = Category::factory()->create();

        $updateData = [
            'name' => 'Updated Category Name',
            'slug' => 'updated-category-name',
        ];

        $response = $this->putJson('/api/categories/' . $category->id, $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('categories', $updateData);
    }

    public function test_can_delete_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson('/api/categories/' . $category->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
