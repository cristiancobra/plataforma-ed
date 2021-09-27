@extends('layouts/index')

@section('title','TEXTOS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonTrashIndex($trashStatus, 'text')}}
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonCreate('text')}}
@endsection


@section('filter')
<form id="filter" action="{{route('text.index')}}" method="get" style="text-align: right">
    <input type="text" name="name" placeholder="nome da tarefa" value="">
    {{createFilterSelect('department', 'select', $departments, 'Todos departamentos')}}
    {{createFilterSelectModels('user_id', 'select', $users, 'Todos os usuários')}}
    {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
    <br>
    <a class="text-button secondary" href='{{route('text.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
<div class='col shortcut prospecting'>
    <a style='text-decoration:none' href='{{route('text.index', ['type' =>'biografia'])}}'>
        <h2>

        </h2>
        <h3>
            biografias
        </h3>
    </a>
</div>
<div class='col shortcut presentation'>
    <a style='text-decoration:none' href='{{route('text.index', ['type' =>'blogs'])}}'>
        <h2>

        </h2>
        <h3>
            blogs
        </h3>
    </a>
</div>

<div class='col shortcut proposal'>
    <a style='text-decoration:none' href='{{route('text.index', ['type' =>'  copy de venda'])}}'>
        <h2>

        </h2>
        <h3>
            copys de venda
        </h3>
    </a>
</div>

<div class='col shortcut contract'>
    <a style='text-decoration:none' href='{{route('text.index', ['type' =>'perguntas frequentes'])}}'>
        <h2>

        </h2>
        <h3>
            perguntas frequentes
        </h3>
    </a>
</div>

<div class='col shortcut bill'>
    <a style='text-decoration:none' href='{{route('text.index', ['type' =>'tutorial'])}}'>
        <h2>

        </h2>
        <h3>
            tutorial
        </h3>
    </a>
</div>

<div class='col shortcut production'>
    <a style='text-decoration:none' href='{{route('text.index', ['type' =>'desativado'])}}'>
        <h2>

        </h2>
        <h3>
            desativado
        </h3>
    </a>
</div>
@endsection


@section('table')
<div class='row mt-2'>
    <div class='col tb tb-header-start justify-content-start'>
        MODELO DE NEGÓCIO
    </div>
</div>

@if($valueOffer)
<div class='row'>
    <div class='col-3 tb justify-content-start' style="font-weight: 600">
        <a class="white me-2" href=" {{ route('text.edit', ['text' => $valueOffer->id]) }}">
            <button class="button-round">
                <i class='fa fa-edit'></i>
            </button>
        </a>
        PROPOSTA DE VALOR
    </div>
    <div class='col-8 tb justify-content-start'>
        {{$valueOffer->text}}
    </div>
    {{formatStatus($valueOffer)}}
</div>
@else
<div class='row'>
    <div class='col-3 tb justify-content-start' style="font-weight: 600">
        <a class="white me-2" href=" {{ route('text.create', ['type' => 'proposta de valor']) }}">
            <button class="button-round">
                <i class='fa fa-plus'></i>
            </button>
        </a>
        PROPOSTA DE VALOR
    </div>
    <div class='col-8 tb justify-content-start'>
        não possui
    </div>
</div>
@endif

@if($about)
<div class='row'>
    <div class='col-3 tb justify-content-start' style="font-weight: 600">
        <a class="white me-2" href=" {{ route('text.edit', ['text' => $about->id]) }}">
            <button class="button-round">
                <i class='fa fa-edit'></i>
            </button>
        </a>
        APRESENTAÇÃO DA EMPRESA
    </div>
    <div class='col-8 tb justify-content-start'>
        {{$about->text}}
    </div>
    {{formatStatus($about)}}
</div>
@else
<div class='row'>
    <div class='col-3 tb justify-content-start' style="font-weight: 600">
        <a class="white me-2" href=" {{ route('text.create', ['type' => 'apresentação da empresa']) }}">
            <button class="button-round">
                <i class='fa fa-plus'></i>
            </button>
        </a>
        APRESENTAÇÃO DA EMPRESA
    </div>
    <div class='col-9 tb justify-content-start'>
        não possui
    </div>
</div>
@endif

@if($strengths->isNotEmpty())
<div class='row mb-5'>
    <div class='col-3 tb justify-content-start' style="font-weight: 600">
        <a class="white me-2" href=" {{ route('text.create', ['type' => 'força']) }}">
            <button class="button-round">
                <i class='fa fa-plus'></i>
            </button>
        </a>
        PONTOS FORTES
    </div>
    <div class='col-9 tb d-block'>
    @foreach($strengths as $strength)
        <div class='row'>
            <div class='col-10'>
                <a class="white me-2" href=" {{ route('text.edit', ['text' => $strength->id]) }}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
            {{$strength->text}}
            </div>
    {{formatStatus($strength)}}
        </div>
    @endforeach
    </div>
</div>
@else
<div class='row mb-5'>
    <div class='col-3 tb justify-content-start' style="font-weight: 600">
        <a class="white me-2" href=" {{ route('text.create', ['type' => 'força']) }}">
            <button class="button-round">
                <i class='fa fa-plus'></i>
            </button>
        </a>
        PONTOS FORTES
    </div>
    <div class='col-9 tb justify-content-start'>
        não possui
    </div>
</div>
@endif

<div class='row mt-2'>
    <div class='tb tb-header-start col-4'>
        NOME
    </div>
    <div class='tb tb-header col-4'>
        TÍTULO
    </div>
    <div class='tb tb-header col-2'>
        RESPONSÁVEL
    </div>
    <div class='tb tb-header col-1'>
        TIPO
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($texts as $text)
<div class='row'>
    <div class='tb col-4 justify-content-start' style="font-weight: 600">
        <a class="white" href=" {{ route('text.show', ['text' => $text->id]) }}">
            <button class="button-round">
                <i class='fa fa-eye'></i>
            </button>
        </a>
        {{$text->name}}
    </div>
    <div class='tb col-4'>
        {{$text->title}}
    </div>
    <div class='tb col-2'>
        @if(isset($text->user->image))
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' => $text->user->id])}}'>
                <img src='{{asset($text->user->image->path)}}' width='100%' height='100%'>
            </a>
        </div>
        @elseif(isset($text->user->contact->name))
        <a  class='white' href=' {{route('user.show', ['user' => $text->user->id])}}'>
            {{$text->user->contact->name}}
        </a>
        @else
        funcionário excluído
        @endif
    </div>

    {{formatType($text)}}

    {{formatStatus($text)}}

</div>
@endforeach
@endsection

@section('paginate', $texts->links())

@section('js-scripts')
@endsection