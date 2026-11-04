@csrf

<div class="mb-3">
<label for="nome" class="form-label">Nome</label>
<input type="text" id="nome" name="nome" maxlength="150"
class="form-control @error('nome') is-invalid @enderror"
value="{{ old('nome', $cliente->nome ?? '') }}">
@error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
<label for="cpf" class="form-label">CPF (somente números)</label>
<input type="text" id="cpf" name="cpf" maxlength="11"
class="form-control @error('cpf') is-invalid @enderror"
value="{{ old('cpf', $cliente->cpf ?? '') }}">
@error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
<label for="email" class="form-label">E-mail</label>
<input type="email" id="email" name="email" maxlength="255"
class="form-control @error('email') is-invalid @enderror"
value="{{ old('email', $cliente->email ?? '') }}">
@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">Salvar</button>
<a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
