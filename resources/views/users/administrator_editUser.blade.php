@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('user.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<form action=" {{ route('user.update', ['user' =>$user->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<label for="" >Nome: </label>
	<input type="text" name="name" value="{{ $user->name }}">
	<br>
	<br>
	<label for="" >Empresas: </label>
	@foreach ($accounts as $account)
	<p class="fields">
		<input type="checkbox" name="accounts[]" value="{{ $account->id}}"
			   @if (in_array($account->id, $accountsChecked))
		checked
		@endif
		>
		{{ $account->name }}
	</p>
	@endforeach
	<br>
	<label for="" >Email: </label>
	<input type="text" name="email" value="{{ $user->email }} ">
	<br>
	<br>
	<label class="labels" for="" >Perfil:</label>
	<select class="fields" name="perfil">
		<option value="{{ $user->perfil }}">{{ $user->perfil }}</option>
		<option value="funcionario">funcionário</option>
		<option value="administrador">administrador</option>
	</select>
	<br>
	<br>
	<label for="">Senha padrão: </label>
	<span class="fields"> {{ $user->default_password }}</span>
	<br>
	<label for="">Alterar senha: </label>
	<input type="text" name="password" value="">   
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" class="button" value="Atualizar dados">
</form>
</div>     
@endsection