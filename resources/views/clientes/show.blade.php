@extends('layouts.app')

@section('titulo', 'Cliente')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
<h1 class="h3 mb-0">{{ $cliente->nome }}</h1>
<a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="bg-white border rounded p-4">
<dl class="row mb-0">
<dt class="col-sm-2">ID</dt>
<dd class="col-sm-10">{{ $cliente->id }}</dd>
<dt class="col-sm-2">CPF</dt>
<dd class="col-sm-10">{{ $cliente->cpf }}</dd>
<dt class="col-sm-2">E-mail</dt>
<dd class="col-sm-10">{{ $cliente->email }}</dd>
</dl>
</div>
@endsection
