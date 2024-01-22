<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tb_produto';
    protected $primaryKey = 'id_produto';
    public $timestamps = false;
    protected $fillable = [
        'id_categoria_produto',
        'data_cadastro',
        'nome_produto',
        'valor_produto',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'id_categoria_produto',
            'id_categoria_planejamento'
        );
    }
}
