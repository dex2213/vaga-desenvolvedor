@extends('layouts.app')

@section('titulo', 'Novo cliente')

@section('conteudo')
<h1 class="h3 mb-3">Novo cliente</h1>

<form action="{{ route('clientes.store') }}" method="POST" class="bg-white border rounded p-4">
@include('clientes._form')
</form>
@endsection
