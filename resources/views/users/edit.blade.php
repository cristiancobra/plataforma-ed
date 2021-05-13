@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('user.index')}}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<form action=" {{route('user.update', ['user' =>$user->id])}} " method="post" enctype='multipart/form-data'>
    @csrf
    @method('put')
    <div class='container text-center'>
        <div class='profile-picture'>
                    @if($user->profile_picture)
                    <img src='{{asset($user->profile_picture)}}' width='100%' height='100%'>
                    @else
                    <img src='{{asset('imagens/colaborador.png')}}' width='100%' height='100%'>
                    @endif
        </div>
        <input  type='file' name='profile_picture' value='{{$user->profile_picture}}'>
    </div>
    <br>
    <br>
	<label for="" >Nome: </label>
	{{$user->contact->name}}
		<a class="white" href=" {{route('contact.show', ['contact' => $user->contact->id])}}">
				<button class="button-round">
					<i class='fa fa-eye'></i>
				</button>
			</a>
			<a href=" {{route('contact.edit', ['contact' => $user->contact->id])}}">
				<button class="button-round">
					<i class='fa fa-edit'></i>
				</button>
			</a>
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
                    @if($user->perfil == 'super administrador')
		<option value="super administrador">super administrador</option>
                @endif
		<option value="funcionario">funcionário</option>
		<option value="administrador">administrador</option>
	</select>
	<br>
	<br>
	<label for="">Senha padrão: </label>
	<input type="text" name="default_password" value="{{ $user->default_password }} ">   
	<br>
	<br>
		<div style="text-align:right;color: #874983;display: inline-block">
			<a class="button-secondary" href="https://www.4devs.com.br/gerador_de_senha"  target="_blank">
				<i class='fa fa-edit'>	
				</i>
				GERADOR DE SENHA
			</a>
		</div>
	<br>
	<br>
	<br>
	<label for="">Alterar senha: </label>
	<input type="text" name="password" value="">   
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" class="button" value="Atualizar dados">
</form>
</div>     
@endsection