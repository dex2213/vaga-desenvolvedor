@extends('layouts.app')

@section('titulo', 'Pedidos')

@section('conteudo')
@php
$colunas = ['id' => 'ID', 'cliente' => 'Cliente', 'data_pedido' => 'Data', 'status' => 'Status', 'total' => 'Total'];
$ordenarPor = request('ordenar_por');
$direcao = request('direcao') === 'desc' ? 'desc' : 'asc';
$cores = ['Em Aberto' => 'warning', 'Pago' => 'success', 'Cancelado' => 'secondary'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h3 mb-0">Pedidos de compra</h1>
<a href="{{ route('pedidos.create') }}" class="btn btn-primary">Novo pedido</a>
</div>

<form id="filtro" method="GET" action="{{ route('pedidos.index') }}"></form>
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
@if ($campo === 'status')
<select name="status" class="form-select form-select-sm" form="filtro">
<option value="">Todos</option>
@foreach (\App\Models\Pedido::STATUS as $status)
<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
@endforeach
</select>
@else
<input type="text" name="{{ $campo }}" value="{{ request($campo) }}"
class="form-control form-control-sm"
placeholder="{{ $campo === 'data_pedido' ? 'AAAA-MM-DD' : 'Filtrar' }}" form="filtro">
@endif
</th>
@endforeach
<th class="text-end">
<button type="submit" class="btn btn-sm btn-secondary" form="filtro">Filtrar</button>
<a href="{{ route('pedidos.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
</th>
</tr>
</thead>
<tbody>
@forelse ($pedidos as $pedido)
<tr>
<td><a href="{{ route('pedidos.show', $pedido) }}">#{{ $pedido->id }}</a></td>
<td><a href="{{ route('clientes.show', $pedido->cliente_id) }}">{{ $pedido->cliente->nome }}</a></td>
<td>{{ $pedido->data_pedido->format('d/m/Y H:i') }}</td>
<td>
<span class="badge text-bg-{{ $cores[$pedido->status] ?? 'light' }}">{{ $pedido->status }}</span>
</td>
<td>R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
<td class="text-end">
<a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-outline-primary">Editar</a>
<form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" class="d-inline"
onsubmit="return confirm('Tem certeza que deseja excluir este pedido?');">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
</form>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="text-center text-muted py-4">Nenhum pedido encontrado.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-3">
{{ $pedidos->links() }}
</div>
@endsection
