<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();

        Pedido::factory(60)
        ->recycle($clientes)
        ->create()
        ->each(function (Pedido $pedido) use ($produtos) {
            $produtos->random(rand(1, 4))->each(function (Produto $produto) use ($pedido) {
                ItemPedido::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $produto->id,
                    'quantidade' => rand(1, 5),
                                   'preco_unitario' => $produto->preco,
                ]);
            });
        });
    }
}
