<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Category;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_get_all_categories(): void
    {
        Category::factory()->count(3)->create();
        $response = $this->get('/api/category');
        $response->assertStatus(200);
        $this->assertCount(3, $response->json()['data']);
    }

    public function test_get_category_by_id()
    {
        $category = Category::factory()->create();
        $response = $this->get('/api/category/' . $category->id_categoria_planejamento);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $category->id_categoria_planejamento,
                'name' => $category->nome_categoria
            ]
        ]);
    }

    public function test_create_category()
    {
        $categoryData = [
            'categoryName' => 'New Category',
        ];
        $response = $this->post('/api/category', $categoryData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('tb_categoria_produto', ['nome_categoria' => 'New Category']);
    }

    public function test_update_category()
    {
        $category = Category::factory()->create();
        $updatedCategoryData = [
            'categoryName' => 'Updated Category',
        ];
        $response = $this->put('/api/category/' . $category->id_categoria_planejamento, $updatedCategoryData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tb_categoria_produto', ['nome_categoria' => 'Updated Category',]);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();
        $response = $this->delete('/api/category/' . $category->id_categoria_planejamento);
        $response->assertStatus(204);
        $this->assertDatabaseMissing(
            'tb_categoria_produto',
            ['id_categoria_planejamento' => $category->id_categoria_planejamento]
        );
    }
}
