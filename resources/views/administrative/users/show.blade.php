@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{asset('images/user.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonEdit('user', 'user', $user)}}
{{createButtonList('user')}}
@endsection

@section('main')
<div class='row'>
    <div class='col-3'>
        <div class='profile-picture'>
            @if($user->image)
            <img src='{{asset($user->image->path)}}' width='100%' height='100%'>
            @else
            <img src='{{asset('images/user.png')}}' width='100%' height='100%'>
            @endif
        </div>
    </div>
    <div class='col-9'>
        <h1 class='name' style="margin-top: 20px">
            {{$user->contact->name}}
        </h1>
        <br>
        <p class='labels'>
            EMAIL DE ACESSO (login):<span class='fields'> {{$user->email}} </span>
        </p>
        <p class='labels'>
            PERFIL: <span class='fields'>  {{$user->perfil}} </span>
        </p>
        <p class='labels'>
            CRIADO EM: <span class='fields'>  {{date('d/m/Y H:i', strtotime($user->created_at))}} </span>
        </p>
        <br>
        <p class='labels'>
            DADOS PESSOAIS  
            <a  class='white' href=' {{route('contact.show', ['contact' => $user->contact_id])}}'>
                <button class='button-round'>
                    <i class='fa fa-eye'></i>
                </button>
            </a>
        </p>
    </div>
</div>

<div class='row mt-5'>
    <div class='tb tb-header-start col-3'>
        TAREFAS
    </div>
    <div class='tb tb-header col-3'>
        CONTATO
    </div>
    <div class='tb tb-header col-3'>
        EMPRESA
    </div>
    <div class='tb tb-header col-1'>
        PRAZO
    </div>
    <div class='tb tb-header col-1'>
        PRIORIDADE
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($userTasks as $task)
<div class='row'>
    <div class='tb col-3 justify-content-start' style="font-weight: 600">
        <a class="white" href=" {{ route('task.show', ['task' => $task->id]) }}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        {{$task->name}}
    </div>
    <div class='tb col-3'>
        <a  class="white" href=" {{ route('contact.show', ['contact' => $task->contact_id]) }}">
            @if(isset($task->contact->name))
            {{$task->contact->name}}
            @else
            contato excluído
            @endif
        </a>
    </div>
    <div class='tb col-3'>
        @if(isset($task->company->name))
        {{$task->company->name}}
        @else
        não possui
        @endif
    </div>

    {{formatDateDue($task)}}

    {{formatPriority($task)}}

    {{formatStatus($task)}}

</div>
@endforeach

<div class='row mt-5 mb-5'>
    <div class="col-sm-8 col-xs-12" style="font-size: 18px">
        {{$userTasks->links()}}
    </div>
    <div class="col-sm-4 col-xs-12 d-inline-block" style="text-align: right">
        <div style='text-align:right;color: #874983; display: inline-block'>
            <form action='{{ route('user.destroy', ['user' => $user->id]) }}' method='post'>
                @csrf
                @method('delete')
                <button id='' class='circular-button delete' style='border:none;padding-left:7px;padding-top: -2px' "type='submit'>
                    <i class='fa fa-trash'></i>
                </button>
            </form>
        </div>
        <div style='text-align:right;color: #874983;display: inline-block'>
            <a class='circular-button secondary' href=' {{ route('user.edit', ['user' => $user->id]) }}'>
                <i class='fa fa-edit'></i>
            </a>
        </div>
        <a class='circular-button primary'  href='{{route('user.index')}}'>
            <i class='fas fa-arrow-left'></i>
        </a>
    </div>
</div>


<p style='text-align: left;margin-left: 30px;color: white;font-size: 14px'>* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>

@endsection