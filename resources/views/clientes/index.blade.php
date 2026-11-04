@extends('layouts.app')

@section('titulo', 'Clientes')

@section('conteudo')
@php
$colunas = ['id' => 'ID', 'nome' => 'Nome', 'cpf' => 'CPF', 'email' => 'E-mail'];
$ordenarPor = request('ordenar_por');
$direcao = request('direcao') === 'desc' ? 'desc' : 'asc';
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h3 mb-0">Clientes</h1>
<a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo cliente</a>
</div>

{{-- Formulário de filtro vazio: os campos da tabela se ligam a ele pelo atributo form --}}
<form id="filtro" method="GET" action="{{ route('clientes.index') }}"></form>
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
<a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
</th>
</tr>
</thead>
<tbody>
@forelse ($clientes as $cliente)
<tr>
<td>{{ $cliente->id }}</td>
<td><a href="{{ route('clientes.show', $cliente) }}">{{ $cliente->nome }}</a></td>
<td>{{ $cliente->cpf }}</td>
<td>{{ $cliente->email }}</td>
<td class="text-end">
<a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-primary">Editar</a>
<form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline"
onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
</form>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="text-center text-muted py-4">Nenhum cliente encontrado.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-3">
{{
