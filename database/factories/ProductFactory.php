<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $category = Category::factory()->create();
        return [
            'id_categoria_produto' => $category->id_categoria_planejamento,
            'data_cadastro' => $this->faker->dateTimeThisMonth,
            'nome_produto' => $this->faker->word,
            'valor_produto' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
