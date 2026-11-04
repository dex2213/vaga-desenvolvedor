<?php

namespace App\Http\Requests;

use App\Models\Pedido;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'data_pedido' => ['required', 'date'],
            'status' => ['required', Rule::in(Pedido::STATUS)],
            'itens' => ['required', 'array', 'min:1'],
            'itens.*.produto_id' => ['required', 'distinct', 'exists:produtos,id'],
            'itens.*.quantidade' => ['required', 'integer', 'min:1'],
            'itens.*.preco_unitario' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'itens.required' => 'Adicione pelo menos um item ao pedido.',
            'itens.min' => 'Adicione pelo menos um item ao pedido.',
            'itens.*.produto_id.required' => 'Selecione o produto.',
            'itens.*.produto_id.distinct' => 'Este produto está repetido no pedido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'itens.*.quantidade' => 'quantidade',
            'itens.*.preco_unitario' => 'preço unitário',
            'itens.*.produto_id' => 'produto',
        ];
    }
}
