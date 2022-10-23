<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = [
    'nome_do_produto',
    'descricao',
    'caminho_imagem',
    'preco',
    'quantidade',
    'categoria',
  ];

  protected $casts = [
    'preco' => 'decimal:2',
  ];
}
