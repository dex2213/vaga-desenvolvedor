@extends('layouts.app')

@section('titulo', 'Editar produto')

@section('conteudo')
<h1 class="h3 mb-3">Editar produto</h1>

<form action="{{ route('produtos.update', $produto) }}" method="POST" class="bg-white border rounded p-4">
@method('PUT')
@include('produtos._form')
</form>
@endsection
