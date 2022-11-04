<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Requests\StoreCategoriaRequest;
use Illuminate\Http\Request;
use App\Models\Log;

use App\Models\Categoria;

class CategoriaController extends Controller
{
    private $categorias;

    public function __construct(Categoria $categoria)
    {
        $this->categorias = $categoria;
    }


    public function index(CategoriaRequest $request)
    {
        $categorias = $this->categorias->all();
        return view('categoria.index', compact('categorias'));
    }


    public function create()
    {
        return view('categoria.crud');
    }


    public function store(StoreCategoriaRequest $request)
    {
        $datas = $request->all();
        $categoria = $this->categorias->create($datas);

        //Log de ações
        $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' cadastrou uma nova categoria ' . '[' . $categoria->id . '] - ' . $categoria->categoria;
        Log::create(['log' => $logMessage, 'category' => 'Categorias']);

        return redirect(route('categoria.index'))->with('success', 'Categoria cadastrada com sucesso!');
    }
    public function show(CategoriaRequest $request, $id)
    {
        $categoria = $this->categorias->find($id);

        return json_encode($categoria);
    }
    public function edit($id)
    {
        $categoria = $this->categorias->find($id);
        return view('categoria.crud', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $datas = $request->all();
        $categoria = $this->categorias->find($id);

        $categoria->update($datas);

        //Log de ações
        $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' alterou a categoria ' . '[' . $categoria->id . '] - ' . $categoria->name;
        Log::create(['log' => $logMessage, 'category' => 'Categoria']);

        return redirect(route('categoria.index'))->with('success', 'Categoria alterada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = $this->categorias->find($id);

        if ($categoria->id > 1) {
            $categoria->delete();

            //Log de ações
            $logMessage = 'O usuário ' . '[' . auth()->id() . '] - ' . auth()->user()->name . ' excluiu a categoria ' . '[' . $categoria->id . '] - ' . $categoria->name;
            Log::create(['log' => $logMessage, 'category' => 'Categoria']);
        }

        return redirect(route('categoria.index'))->with('success', 'Categoria excluída com sucesso!');
    }
}
