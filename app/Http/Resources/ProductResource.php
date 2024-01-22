<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_produto,
            'categoryId' => $this->id_categoria_produto,
            'date' => $this->data_cadastro,
            'productName' => $this->nome_produto,
            'price' => $this->valor_produto,
            'category' => new CategoryResource($this->category)
        ];
    }
}
