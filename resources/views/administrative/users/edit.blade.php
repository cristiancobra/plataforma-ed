@extends('layouts/edit')

@section('title','USUÁRIOS')

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


    @section('label1', 'CONTATO')
    @section('content1')
    @if(!isset($user->contact->name))
    contato excluído
    @else
    <a class='white' href=' {{route('contact.edit', ['contact' => $user->contact_id])}}'>
        {{$user->contact->name}}
    </a>
    @endif
    @endsection


    @section('label2', 'EMAIL DE ACESSO')
    @section('content2')
    <input class="w-100" type="text" name="email" value="{{$user->email}}">
    </input>
    @endsection


    @section('label3', 'PERFIL')
    @section('content3')
    <select name="perfil">
        <option class="fields" value="{{$user->perfil}}">
            {{$user->perfil}}
        </option>
        @foreach($roles as $role)
        <option class="fields" value="{{$role}}">
            {{$role}}
        </option>
        @endforeach
    </select>
    @endsection


    @section('date_start')
    <div class='circle-date-start'>
        {{dateBr($user->created_at)}}
    </div>
    <p class='labels' style='text-align: center'>
        DATA DE CRIAÇÃO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        {{dateBr($user->updated_at)}}
        <br>
        {{timeBr($user->updated_at)}}
    </div>
    <p class='labels' style='text-align: center'>
        ÚLTIMA ATUALIZAÇÃO
    </p>
    @endsection






    @section('main')
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



        <input type="hidden" name="alt" id="alt" value="foto do usuário {{$user->contact->name}}">
        <input type="hidden" name="image_type" value="imagem perfil">
        <input type="hidden" name="name" id="name" value="foto do usuário {{$user->contact->name}}">

        @endsection