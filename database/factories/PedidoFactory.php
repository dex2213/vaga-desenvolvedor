<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'data_pedido' => fake()->dateTimeBetween('-6 months', 'now'),
            'status' => fake()->randomElement(['Em Aberto', 'Pago', 'Cancelado']),
        ];
    }
}
