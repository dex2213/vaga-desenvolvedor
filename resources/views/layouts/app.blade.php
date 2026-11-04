<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('titulo') - Pedidos de Compra</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
<div class="container">
<a class="navbar-brand" href="{{ route('clientes.index') }}">Pedidos de Compra</a>
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}"
href="{{ route('clientes.index') }}">Clientes</a>
</li>
</ul>
</div>
</nav>

<main class="container pb-5">
@if (session('sucesso'))
<div class="alert alert-success">{{ session('sucesso') }}</div>
@endif

@if (session('erro'))
<div class="alert alert-danger">{{ session('erro') }}</div>
@endif

@yield('conteudo')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
