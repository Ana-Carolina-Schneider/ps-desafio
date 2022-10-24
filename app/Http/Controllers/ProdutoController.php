<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProdutoController extends Controller
{
    private $produtos;

    public function __construct(Produto $produto)
    {
        $this->produtos = $produto;
    }

    public function index(ProdutoRequest $request)
    {
        $produtos = $this->produtos->all();
        return view('admin.produto.index', compact('produtos'));
    }


    public function create()
    {
        return view('admin.produto.crud');
    }


    public function store(ProdutoRequest $request)
    {
        $datas = $request->all();
        $produto = $this->produtos->create($datas);

        //Log de ações
        $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' cadastrou um novo produto ' . '[' . $produto->id . '] - ' . $produto->produto;
        Log::create(['log' => $logMessage, 'category' => 'Produtos']);

        return redirect(route('produto.index'))->with('success', 'Produto cadastrado com sucesso!');
    }


    public function show($id)
    {
        $produto = $this->produtos->find($id);

        return json_encode($produto);
    }


    public function edit($id)
    {
        $produto = $this->produtos->find($id);
        return view('admin.produto.crud', compact('produto'));
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
