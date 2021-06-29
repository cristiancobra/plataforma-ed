@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('images/user.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('user')}}
@endsection

@section('main')
<form action=" {{route('user.update', ['user' =>$user->id])}} " method="post" enctype='multipart/form-data'>
    @csrf
    @method('put')
        <div class="col-6">
        <label class="labels" for="" >ADICIONAR NOVA IMAGEM:</label>
        <label class="switch">
            <input type="checkbox" id="slider">
            <span class="slider round"></span>
        </label>
        <br>
        <br>
        <div id="change" style="display:inline">
            <label class="labels" for="" >SELECIONAR IMAGEM:</label>
            {{createSelectIdName('image_id', 'select', $images, 'Nenhuma', $user->image)}}
        </div>
        <div id="new" style="display:none">
            <label class="labels" for="" >NOME DA IMAGEM:</label>
            <input type="text" name="name" id="name" size="20"><span class="fields"></span>
            <br>
            <label class="labels" for="" >DESCRIÇÃO DA IMAGEM:</label>
            <textarea id="alt" name="alt" id="alt" rows="3" cols="50">
            </textarea>
            <br>
            <br>
            <input type='file' name='image'>
            <div class="p-2 flex-shrink-0 bd-highlight">
                <button class="btn btn-primary" id="btn-save">
                    Add Todo
                </button>
            </div>
            <input type="hidden" name="image_type" value="produto"><span class="fields"></span>
        </div>
    </div>
    <div class='container text-center'>
        <div class='profile-picture'>
            @if($user->image)
            <img src='{{asset($user->image->path)}}' width='100%' height='100%'>
            @else
            <img src='{{asset('images/user.png')}}' width='100%' height='100%'>
            @endif
        </div>
    </div>
    <br>
    <br>
    <label for="" >Nome: </label>
    {{$user->name}}
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