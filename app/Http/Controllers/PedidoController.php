<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    private const TOTAL_SQL = '(select coalesce(sum(quantidade * preco_unitario), 0) from item_pedidos where item_pedidos.pedido_id = pedidos.id)';

    public function index(Request $request)
    {
        $busca = fn (string $campo): string => is_string($request->query($campo)) ? trim($request->query($campo)) : '';

        $query = Pedido::query()
        ->select('pedidos.*')
        ->selectRaw(self::TOTAL_SQL . ' as total')
        ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
        ->with('cliente');

        if ($busca('id') !== '') {
            $query->where('pedidos.id', 'like', '%' . $busca('id') . '%');
        }

        if ($busca('cliente') !== '') {
            $query->where('clientes.nome', 'like', '%' . $busca('cliente') . '%');
        }

        if ($busca('data_pedido') !== '') {
            $query->where('pedidos.data_pedido', 'like', '%' . $busca('data_pedido') . '%');
        }

        if (in_array($busca('status'), Pedido::STATUS, true)) {
            $query->where('pedidos.status', $busca('status'));
        }

        if ($busca('total') !== '') {
            $query->whereRaw(self::TOTAL_SQL . ' like ?', ['%' . $busca('total') . '%']);
        }

        // Só ordena por colunas da lista permitida (evita SQL injection)
        $ordenaveis = [
            'id' => 'pedidos.id',
            'cliente' => 'clientes.nome',
            'data_pedido' => 'pedidos.data_pedido',
            'status' => 'pedidos.status',
            'total' => 'total',
        ];
        $direcao = $busca('direcao') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($ordenaveis[$busca('ordenar_por')] ?? 'pedidos.id', $direcao);

        $pedidos = $query->paginate(20)->withQueryString();

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create', $this->dadosFormulario());
    }

    public function store(StorePedidoRequest $request)
    {
        $dados = $request->validated();

        DB::transaction(function () use ($dados) {
            $pedido = Pedido::create([
                'cliente_id' => $dados['cliente_id'],
                'data_pedido' => $dados['data_pedido'],
                'status' => $dados['status'],
            ]);

            $pedido->itens()->createMany(array_values($dados['itens']));
        });

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido cadastrado com sucesso.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'itens.produto']);

        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load('itens');

        return view('pedidos.edit', array_merge(['pedido' => $pedido], $this->dadosFormulario()));
    }

    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        $dados = $request->validated();

        DB::transaction(function () use ($dados, $pedido) {
            $pedido->update([
                'cliente_id' => $dados['cliente_id'],
                'data_pedido' => $dados['data_pedido'],
                'status' => $dados['status'],
            ]);

            $pedido->itens()->delete();
            $pedido->itens()->createMany(array_values($dados['itens']));
        });

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido)
    {
        DB::transaction(function () use ($pedido) {
            $pedido->itens()->delete();
            $pedido->delete();
        });

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido excluído com sucesso.');
    }

    private function dadosFormulario(): array
    {
        return [
            'clientes' => Cliente::orderBy('nome')->get(['id', 'nome']),
            'produtos' => Produto::orderBy('titulo')->get(['id', 'sku', 'titulo', 'preco']),
        ];
    }
}
