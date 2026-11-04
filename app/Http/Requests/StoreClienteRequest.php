<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:150'],
            'cpf' => ['required', 'digits:11', 'unique:clientes,cpf'],
            'email' => ['required', 'email', 'max:255', 'unique:clientes,email'],
        ];
    }
}
