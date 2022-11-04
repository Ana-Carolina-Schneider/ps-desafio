<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
  use HasFactory;

  protected $fillable = [
    'nome_do_produto',
    'descricao',
    'caminho_imagem',
    'preco',
    'quantidade',
    'categoria_id',
  ];

  protected $casts = [
    'preco' => 'decimal:2',
  ];
}
