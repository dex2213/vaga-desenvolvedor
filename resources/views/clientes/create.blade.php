@extends('layouts.app')

@section('titulo', 'Novo pedido')

@section('conteudo')
<h1 class="h3 mb-3">Novo pedido</h1>

<form action="{{ route('pedidos.store') }}" method="POST" class="bg-white border rounded p-4">
@include('pedidos._form')
</form>
@endsection
