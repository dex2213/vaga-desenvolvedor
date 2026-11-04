@extends('layouts.app')

@section('titulo', 'Editar pedido')

@section('conteudo')
<h1 class="h3 mb-3">Editar pedido #{{ $pedido->id }}</h1>

<form action="{{ route('pedidos.update', $pedido) }}" method="POST" class="bg-white border rounded p-4">
@method('PUT')
@include('pedidos._form')
</form>
@endsection
