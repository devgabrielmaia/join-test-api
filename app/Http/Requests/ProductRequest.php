<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoryId' => 'required|exists:tb_categoria_produto,id_categoria_planejamento',
            'productName' => 'required|string|max:150',
            'price' => 'required|numeric',
        ];
    }
}
