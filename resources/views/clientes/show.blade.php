@extends('layouts.app')

@section('titulo', 'Produto')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h3 mb-0">{{ $produto->titulo }}</h1>
<a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="bg-white border rounded p-4">
<dl class="row mb-0">
<dt class="col-sm-2">ID</dt>
<dd class="col-sm-10">{{ $produto->id }}</dd>
<dt class="col-sm-2">SKU</dt>
<dd class="col-sm-10">{{ $produto->sku }}</dd>
<dt class="col-sm-2">Preço</dt>
<dd class="col-sm-10">R$ {{ number_format($produto->preco, 2, ',', '.') }}</dd>
<dt class="col-sm-2">Estoque</dt>
<dd class="col-sm-10">{{ $produto->estoque }}</dd>
<dt class="col-sm-2">Em pedidos</dt>
<dd class="col-sm-10">{{ $produto->itens_count }} {{ $produto->itens_count === 1 ? 'item' : 'itens' }}</dd>
</dl>
</div>
@endsection
