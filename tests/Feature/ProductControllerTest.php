<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_get_all_products()
    {
        Product::factory()->count(3)->create();
        $response = $this->get('/api/product');
        $response->assertStatus(200);
        $this->assertCount(3, $response->json()['data']);
    }

    public function test_get_product_by_id()
    {
        $product = Product::factory()->create();
        $response = $this->get('/api/product/' . $product->id_produto);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $product->id_produto,
                'categoryId' => $product->id_categoria_produto,
                'productName' => $product->nome_produto,
                'price' => $product->valor_produto,
                'date' => $product->data_cadastro->format('Y-m-d H:i:s'),
                'category' => [
                    'id' => $product->category->id_categoria_planejamento,
                    'name' => $product->category->nome_categoria
                ]
            ]
        ]);
    }

    public function test_create_product()
    {
        $category = Category::factory()->create();
        $productData = [
            'productName' => 'New Product',
            'price' => 15.99,
            'categoryId' => $category->id_categoria_planejamento,
        ];
        $response = $this->post('/api/product', $productData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tb_produto', [
            'nome_produto' => 'New Product',
            'valor_produto' => 15.99,
            'id_categoria_produto' => $category->id_categoria_planejamento,
        ]);
    }

    public function test_update_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $updatedProductData = [
            'productName' => 'Updated Product',
            'price' => 15.99,
            'categoryId' => $category->id_categoria_planejamento,
        ];
        $response = $this->put('/api/product/' . $product->id_produto, $updatedProductData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tb_produto', [
            'nome_produto' => 'Updated Product',
            'valor_produto' => 15.99,
            'id_categoria_produto' => $category->id_categoria_planejamento,
        ]);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->delete('/api/product/' . $product->id_produto);
        $response->assertStatus(204);
        $this->assertDatabaseMissing(
            'tb_produto',
            ['id_produto' => $product->id_produto]
        );
    }
}
