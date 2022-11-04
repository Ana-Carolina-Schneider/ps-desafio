<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Http\Requests\ProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Http\Requests\StoreProdutoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Log;
use SebastianBergmann\Complexity\Complexity;

class ProdutoController extends Controller
{
    private $produtos;
    private $categorias;

    public function __construct(Produto $produtos, Categoria $categorias)
    {
        $this->produtos = $produtos;
        $this->categorias = $categorias;
    }

    public function index()
    {
        $produtos = $this->produtos->all();
        return view('produto.index', compact('produtos'));
    }


    public function create()
    {
        $categorias = $this->categorias->all();
        return view('produto.crud', compact('categorias'));
    }


    public function store(StoreProdutoRequest $request)
    {
        $datas = $request->all();
        if ($request->hasFile('caminho_imagem')) {
            $data['caminho_imagem'] = '/storage/' . $request->file('caminho_imagem')->store('produtos', 'public');
        }
        $produto = $this->produtos->create($datas);


        //Log de ações
        $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' cadastrou um novo produto ' . '[' . $produto->id . '] - ' . $produto->produto;
        Log::create(['log' => $logMessage, 'category' => 'Produtos']);

        return redirect(route('produto.index'))->with('success', 'Produto cadastrado com sucesso!');
    }


    public function show($id)
    {
        $produto = $this->produtos->find($id);
        $categoria = $this->categorias->find($produto->categoria_id);

        return json_encode([$produto, $categoria]);
    }


    public function edit($id)
    {
        $produto = $this->produtos->find($id);
        $categoria = Categoria::pluck('categorias', $produto->categorias);
        return view('produto.crud', compact('produto'))->with('categorias', $categoria);
    }


    public function update(Request $request, $id)
    {
        $datas = $request->all();
        $produto = $this->produtos->find($id);

        $produto->update($datas);

        //Log de ações
        $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' alterou o produto ' . '[' . $produto->id . '] - ' . $produto->name;
        Log::create(['log' => $logMessage, 'category' => 'Categoria']);

        return redirect(route('produto.index'))->with('success', 'Produto alterado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = $this->produtos->find($id);

        if ($produto->id > 1) {
            $produto->delete();

            //Log de ações
            $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' excluiu o produto' . '[' . $produto->id . '] - ' . $produto->name;
            Log::create(['log' => $logMessage, 'category' => 'Produto']);
        }

        return redirect(route('produto.index'))->with('success', 'Produto excluído com sucesso!');
    }
}
