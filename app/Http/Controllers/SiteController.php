<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    private $produtos;
    private $categorias;

    public function __construct(Produto $produtos, Categoria $categorias)
    {
        $this->produtos = $produtos;
        $this->categorias = $categorias;
    }

    public function index(Request $request)
    {
        $produtos = $this->produtos->all();
        $categorias = $this->categorias->all();
        return view('site.index', compact('produtos', 'categorias'));
    }
}
