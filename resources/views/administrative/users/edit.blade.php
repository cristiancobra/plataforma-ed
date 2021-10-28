@extends('layouts/edit')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('images/user.png') }} 
@endsection


@section('form_start')
<form action=" {{route('user.update', ['user' =>$user->id])}} " method="post" enctype='multipart/form-data'>
    @csrf
    @method('put')
    @endsection


    @section('buttons')
    {{createButtonCancel()}}
    {{createButtonSave()}}
    @endsection

    @section('name')
    {{$user->contact->name}}
    @endsection


    @section('status')
    PERFIL:
    <select class="fields" name="perfil">
        <option value="{{ $user->perfil }}">
            {{ $user->perfil }}
        </option>
        @if(auth()->user()->perfil == 'super administrador')
        <option value="super administrador">
            super administrador
        </option>
        @endif
        <option value="funcionario">
            funcionário
        </option>
        <option value="administrador">
            administrador
        </option>
    </select>
    @endsection

    @section('status')
    PERFIL:
    <select class="fields" name="perfil">
        <option value="{{ $user->perfil }}">
            {{ $user->perfil }}
        </option>
        @if(auth()->user()->perfil == 'super administrador')
        <option value="super administrador">
            super administrador
        </option>
        @endif
        <option value="funcionario">
            funcionário
        </option>
        <option value="administrador">
            administrador
        </option>
    </select>
    @endsection


    @section('fieldsId')
    <div class="row">
        <div class="col-4">
            <div class="row mt-4">
                <div class='profile-picture'>
                    @if($user->image)
                    <img src='{{asset($user->image->path)}}' width='100%' height='100%'>
                    @else
                    <img src='{{asset('images/user.png')}}' width='100%' height='100%'>
                    @endif
                </div>
            </div>
            <div class="row mt-3">
                <div class="col d-flex justify-content-center">
                    <p class='labels pt-2'>
                        ALTERAR:
                    </p>
                    {{createSelectIdName('image_id', 'fields', $images, 'nenhuma', $user->image)}}
                </div>
            </div>
            <div class="row mt-4">
                <div class="col d-flex justify-content-center text-button ms-5 me-5 pt-2" style="background-color: {{$oppositeColor}}">
                    <i class='fa fa-camera me-3' style='color:white;font-size: 22px'></i>
                    <label for="image" class="labels" style='color:white'>
                        NOVA FOTO
                    </label>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col d-flex justify-content-center">
                    <input type='file' id='image' name='image'>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col">
                    <label  class='labels' for="" >Email de acesso (login): </label>
                    <input type="text" name="email" size='40' value="{{ $user->email }} ">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <p class='labels'>
                        DADOS PESSOAIS  
                        <a  class='white' href=' {{route('contact.edit', ['contact' => $user->contact_id])}}'>
                            <button class='button-round'>
                                <i class='fa fa-edit'></i>
                            </button>
                        </a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <p class='labels'>
                        Nome:
                    </p>
                </div>
                <div class="col-11">
                    <p>
                        {{$user->contact->name}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <p class='labels'>
                        Email:
                    </p>
                </div>
                <div class="col-11">
                    <p>
                        {{$user->contact->email}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <p class='labels'>
                        Telefone:
                    </p>
                </div>
                <div class="col-11">
                    <p>
                        {{$user->contact->phone}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endsection


    @section('description')
    {{$user->contact->observations}}
    @endsection


    @section('main')
    <input type="hidden" name="alt" id="alt" value="foto do usuário {{$user->contact->name}}">
    <input type="hidden" name="image_type" value="imagem perfil">
    <input type="hidden" name="name" id="name" value="foto do usuário {{$user->contact->name}}">

    @endsection