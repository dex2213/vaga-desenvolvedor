<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $produtos = Produto::filtrar($request)->paginate(20)->withQueryString();

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(StoreProdutoRequest $request)
    {
        Produto::create($request->validated());

        return redirect()->route('produtos.index')->with('sucesso', 'Produto cadastrado com sucesso.');
    }

    public function show(Produto $produto)
    {
        $produto->loadCount('itens');

        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->validated());

        return redirect()->route('produtos.index')->with('sucesso', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->itens()->exists()) {
            return redirect()->route('produtos.index')
            ->with('erro', 'Não é possível excluir um produto que está em pedidos.');
        }

        $produto->delete();

        return redirect()->route('produtos.index')->with('sucesso', 'Produto excluído com sucesso.');
    }
}
