@csrf

<div class="mb-3">
<label for="sku" class="form-label">SKU</label>
<input type="text" id="sku" name="sku" maxlength="100"
class="form-control @error('sku') is-invalid @enderror"
value="{{ old('sku', $produto->sku ?? '') }}">
@error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
<label for="titulo" class="form-label">Título</label>
<input type="text" id="titulo" name="titulo" maxlength="100"
class="form-control @error('titulo') is-invalid @enderror"
value="{{ old('titulo', $produto->titulo ?? '') }}">
@error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
<div class="col-md-6 mb-3">
<label for="preco" class="form-label">Preço (R$)</label>
<input type="number" id="preco" name="preco" step="0.01" min="0"
class="form-control @error('preco') is-invalid @enderror"
value="{{ old('preco', $produto->preco ?? '') }}">
@error('preco') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-md-6 mb-3">
<label for="estoque" class="form-label">Estoque</label>
<input type="number" id="estoque" name="estoque" step="1" min="0"
class="form-control @error('estoque') is-invalid @enderror"
value="{{ old('estoque', $produto->estoque ?? 0) }}">
@error('estoque') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
</div>

<button type="submit" class="btn btn-primary">Salvar</button>
<a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
