@php
$pedido = $pedido ?? null;
$itensForm = old('itens', $pedido
? $pedido->itens->map(fn ($item) => [
    'produto_id' => $item->produto_id,
    'quantidade' => $item->quantidade,
    'preco_unitario' => $item->preco_unitario,
])->all()
: [['produto_id' => '', 'quantidade' => 1, 'preco_unitario' => '']]);
$dataPedido = old('data_pedido', $pedido?->data_pedido?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i'));
$statusAtual = old('status', $pedido->status ?? 'Em Aberto');
@endphp

@csrf

<div class="row">
<div class="col-md-5 mb-3">
<label for="cliente_id" class="form-label">Cliente</label>
<select id="cliente_id" name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror">
<option value="">Selecione o cliente</option>
@foreach ($clientes as $cliente)
<option value="{{ $cliente->id }}" @selected((string) old('cliente_id', $pedido->cliente_id ?? '') === (string) $cliente->id)>
{{ $cliente->nome }}
</option>
@endforeach
</select>
@error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-md-4 mb-3">
<label for="data_pedido" class="form-label">Data do pedido</label>
<input type="datetime-local" id="data_pedido" name="data_pedido" value="{{ $dataPedido }}"
class="form-control @error('data_pedido') is-invalid @enderror">
@error('data_pedido') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-md-3 mb-3">
<label for="status" class="form-label">Status</label>
<select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
@foreach (\App\Models\Pedido::STATUS as $status)
<option value="{{ $status }}" @selected($statusAtual === $status)>{{ $status }}</option>
@endforeach
</select>
@error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
</div>

<h2 class="h5 mt-2">Itens do pedido</h2>

@error('itens') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

<div id="lista-itens">
@foreach ($itensForm as $i => $item)
<div class="row g-2 align-items-start mb-2 item-linha">
<div class="col-md-5">
<select name="itens[{{ $i }}][produto_id]"
class="form-select item-produto @error("itens.$i.produto_id") is-invalid @enderror">
<option value="">Selecione o produto</option>
@foreach ($produtos as $produto)
<option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}"
@selected((string) ($item['produto_id'] ?? '') === (string) $produto->id)>
{{ $produto->sku }} - {{ $produto->titulo }}
</option>
@endforeach
</select>
@error("itens.$i.produto_id") <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-2">
<input type="number" name="itens[{{ $i }}][quantidade]" min="1" step="1" placeholder="Qtd."
value="{{ $item['quantidade'] ?? 1 }}"
class="form-control item-quantidade @error("itens.$i.quantidade") is-invalid @enderror">
@error("itens.$i.quantidade") <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-3">
<input type="number" name="itens[{{ $i }}][preco_unitario]" min="0" step="0.01" placeholder="Preço unitário"
value="{{ $item['preco_unitario'] ?? '' }}"
class="form-control item-preco @error("itens.$i.preco_unitario") is-invalid @enderror">
@error("itens.$i.preco_unitario") <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-2">
<button type="button" class="btn btn-outline-danger w-100 remover-item">Remover</button>
</div>
</div>
@endforeach
</div>

<template id="modelo-item">
<div class="row g-2 align-items-start mb-2 item-linha">
<div class="col-md-5">
<select name="itens[__INDEX__][produto_id]" class="form-select item-produto">
<option value="">Selecione o produto</option>
@foreach ($produtos as $produto)
<option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
{{ $produto->sku }} - {{ $produto->titulo }}
</option>
@endforeach
</select>
</div>
<div class="col-md-2">
<input type="number" name="itens[__INDEX__][quantidade]" min="1" step="1" placeholder="Qtd."
value="1" class="form-control item-quantidade">
</div>
<div class="col-md-3">
<input type="number" name="itens[__INDEX__][preco_unitario]" min="0" step="0.01" placeholder="Preço unitário"
class="form-control item-preco">
</div>
<div class="col-md-2">
<button type="button" class="btn btn-outline-danger w-100 remover-item">Remover</button>
</div>
</div>
</template>

<div class="d-flex justify-content-between align-items-center my-3">
<button type="button" id="adicionar-item" class="btn btn-outline-secondary">Adicionar item</button>
<strong>Total: R$ <span id="total-pedido">0,00</span></strong>
</div>

<button type="submit" class="btn btn-primary">Salvar</button>
<a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Cancelar</a>

<script>
(function () {
    const lista = document.getElementById('lista-itens');
    const modelo = document.getElementById('modelo-item').innerHTML;
    let proximo = {{ max(array_keys($itensForm)) + 1 }};

    function recalcular() {
        let total = 0;
        lista.querySelectorAll('.item-linha').forEach(function (linha) {
            const qtd = parseFloat(linha.querySelector('.item-quantidade').value) || 0;
            const preco = parseFloat(linha.querySelector('.item-preco').value) || 0;
            total += qtd * preco;
        });
        document.getElementById('total-pedido').textContent =
        total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.getElementById('adicionar-item').addEventListener('click', function () {
        lista.insertAdjacentHTML('beforeend', modelo.replaceAll('__INDEX__', proximo++));
        recalcular();
    });

    lista.addEventListener('click', function (e) {
        const botao = e.target.closest('.remover-item');
        if (botao && lista.querySelectorAll('.item-linha').length > 1) {
            botao.closest('.item-linha').remove();
            recalcular();
        }
    });

    lista.addEventListener('change', function (e) {
        if (e.target.classList.contains('item-produto')) {
            const opcao = e.target.selectedOptions[0];
            const preco = e.target.closest('.item-linha').querySelector('.item-preco');
            preco.value = opcao && opcao.dataset.preco ? opcao.dataset.preco : '';
        }
        recalcular();
    });

    lista.addEventListener('input', recalcular);
    recalcular();
})();
</script>
