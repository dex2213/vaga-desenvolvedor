<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cliente = $this->route('cliente');

        return [
            'nome' => ['required', 'string', 'max:150'],
            'cpf' => ['required', 'digits:11', Rule::unique('clientes', 'cpf')->ignore($cliente)],
            'email' => ['required', 'email', 'max:255', Rule::unique('clientes', 'email')->ignore($cliente)],
        ];
    }
}
