@extends('layouts.app')

@section('titulo', 'Produtos')

@section('conteudo')
@php
$colunas = ['id' => 'ID', 'sku' => 'SKU', 'titulo' => 'Título', 'preco' => 'Preço', 'estoque' => 'Estoque'];
$ordenarPor = request('ordenar_por');
$direcao = request('direcao') === 'desc' ? 'desc' : 'asc';
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h3 mb-0">Produtos</h1>
<a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo produto</a>
</div>

<form id="filtro" method="GET" action="{{ route('produtos.index') }}"></form>
<input type="hidden" name="ordenar_por" value="{{ $ordenarPor }}" form="filtro">
<input type="hidden" name="direcao" value="{{ $direcao }}" form="filtro">

<div class="table-responsive bg-white border rounded">
<table class="table table-hover align-middle mb-0">
<thead>
<tr>
@foreach ($colunas as $campo => $rotulo)
@php $proxima = ($ordenarPor === $campo && $direcao === 'asc') ? 'desc' : 'asc'; @endphp
<th>
<a class="text-decoration-none text-dark"
href="{{ request()->fullUrlWithQuery(['ordenar_por' => $campo, 'direcao' => $proxima, 'page' => 1]) }}">
{{ $rotulo }}
@if ($ordenarPor === $campo)
{{ $direcao === 'asc' ? '▲' : '▼' }}
@endif
</a>
</th>
@endforeach
<th class="text-end">Ações</th>
</tr>
<tr>
@foreach ($colunas as $campo => $rotulo)
<th>
<input type="text" name="{{ $campo }}" value="{{ request($campo) }}"
class="form-control form-control-sm" placeholder="Filtrar" form="filtro">
</th>
@endforeach
<th class="text-end">
<button type="submit" class="btn btn-sm btn-secondary" form="filtro">Filtrar</button>
<a href="{{ route('produtos.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
</th>
</tr>
</thead>
<tbody>
@forelse ($produtos as $produto)
<tr>
<td>{{ $produto->id }}</td>
<td>{{ $produto->sku }}</td>
<td><a href="{{ route('produtos.show', $produto) }}">{{ $produto->titulo }}</a></td>
<td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
<td>{{ $produto->estoque }}</td>
<td class="text-end">
<a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-primary">Editar</a>
<form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline"
onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
</form>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="text-center text-muted py-4">Nenhum produto encontrado.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-3">
{{ $produtos->links() }}
</div>
@endsection
