@extends('layouts.app')

@section('titulo', 'Editar cliente')

@section('conteudo')
<h1 class="h3 mb-3">Editar cliente</h1>

<form action="{{ route('clientes.update', $cliente) }}" method="POST" class="bg-white border rounded p-4">
@method('PUT')
@include('clientes._form')
</form>
@endsection
