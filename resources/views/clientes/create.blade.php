@extends('layouts.app')

@section('titulo', 'Novo produto')

@section('conteudo')
<h1 class="h3 mb-3">Novo produto</h1>

<form action="{{ route('produtos.store') }}" method="POST" class="bg-white border rounded p-4">
@include('produtos._form')
</form>
@endsection
