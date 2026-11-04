<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filtravel
{
    public function scopeFiltrar(Builder $query, Request $request): Builder
    {
        $colunas = $this->filtraveis;

        foreach ($colunas as $coluna) {
            $valor = $request->query($coluna);

            if (is_string($valor) && $valor !== '') {
                $query->where($coluna, 'like', '%' . $valor . '%');
            }
        }

        $ordenarPor = $request->query('ordenar_por');
        $direcao = $request->query('direcao') === 'desc' ? 'desc' : 'asc';

        // Só ordena por colunas da lista permitida (evita SQL injection)
        if (in_array($ordenarPor, $colunas, true)) {
            $query->orderBy($ordenarPor, $direcao);
        } else {
            $query->orderBy('id');
        }

        return $query;
    }
}
