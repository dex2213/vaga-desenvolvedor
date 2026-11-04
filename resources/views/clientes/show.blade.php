@extends('layouts.app')

@section('titulo', 'Pedido')

@section('conteudo')
@php $cores = ['Em Aberto' => 'warning', 'Pago' => 'success', 'Cancelado' => 'secondary']; @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h3 mb-0">Pedido #{{ $pedido->id }}</h1>
<div>
<a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-outline-primary">Editar</a>
<a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Voltar</a>
</div>
</div>

<div class="bg-white border rounded p-4 mb-4">
<dl class="row mb-0">
<dt class="col-sm-2">Cliente</dt>
<dd class="col-sm-10">
<a href="{{ route('clientes.show', $pedido->cliente) }}">{{ $pedido->cliente->nome }}</a>
</dd>
<dt class="col-sm-2">Data</dt>
<dd class="col-sm-10">{{ $pedido->data_pedido->format('d/m/Y H:i') }}</dd>
<dt class="col-sm-2">Status</dt>
<dd class="col-sm-10">
<span class="badge text-bg-{{ $cores[$pedido->status] ?? 'light' }}">{{ $pedido->status }}</span>
</dd>
<dt class="col-sm-2">Total</dt>
<dd class="col-sm-10">R$ {{ number_format($pedido->valorTotal(), 2, ',', '.') }}</dd>
</dl>
</div>

<h2 class="h5">Itens</h2>
<div class="table-responsive bg-white border rounded">
<table class="table align-middle mb-0">
<thead>
<tr>
<th>Produto</th>
<th>Quantidade</th>
<th>Preço unitário</th>
<th>Subtotal</th>
</tr>
</thead>
<tbody>
@foreach ($pedido->itens as $item)
<tr>
<td>
<a href="{{ route('produtos.show', $item->produto) }}">
{{ $item->produto->sku }} - {{ $item->produto->titulo }}
</a>
</td>
<td>{{ $item->quantidade }}</td>
<td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
<td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
