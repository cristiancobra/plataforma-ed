@extends('layouts/index')

@section('title', 'IMAGENS')

@section('image-top')
    <i class="fas fa-image"></i>
@endsection


@section('buttons')
    {{ createButtonTrashIndex($trashStatus, 'image') }}
    <a id='filter_button' class='circular-button secondary' title='Filtrar lista'>
        <i class='fa fa-filter' aria-hidden='true'></i>
    </a>
    <a class="circular-button primary" href="{{ route('image.create') }}">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
@endsection

@section('filter')
    <form id='filter' action='{{ route('image.index') }}' method='get' style='text-align: right'>
        <input type='text' name='name' placeholder='nome' value=''>
        {{ createFilterSelect('type', 'select', $types) }}
        <br>
        <a class='text-button secondary' href='{{ route('image.index') }}'>
            LIMPAR
        </a>
        <input class='text-button primary' type='submit' value='FILTRAR'>
    </form>
@endsection

@section('shortcuts')

@endsection


@section('table')
    <div class="row table-header mb-2" style="background-color: {{ $principalColor }}">
        <div class='col-2'>
            IMAGEM
        </div>
        <div class='col-5'>
            NOME
        </div>
        <div class='col-2'>
            TIPO
        </div>
        <div class='col-2'>
            ENVIADO POR
        </div>
        <div class='col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($images as $image)
        <div class='row'>
            <div class='tb col-2' style="background-color: lightgray">
                <div class='product-image-small'>
                    <a href=' {{ route('image.show', ['image' => $image->id]) }}'>
                        <img src='{{ asset('storage/' . $image->path) }}' width='100%' heigh='100%'>
                    </a>
                </div>
            </div>
            <div class='tb col-5'>
                {{ $image->name }}
            </div>
            <div class='tb col-2 text-center'>
                {{ $image->type }}
            </div>
            <div class='tb col-2'>
                @if ($image->contact_id != null or $image->contact_id != 0)
                    <a class='white' href=' {{ route('contact.show', ['contact' => $image->contact_id]) }}'>
                        {{ $image->contact->name }}
                    </a>
                @elseif(isset($image->user->image))
                    <div class='profile-picture-small'>
                        <a class='white' href=' {{ route('user.show', ['user' => $image->user_id]) }}'>
                            <img src='{{ asset($image->user->image->path) }}' width='100%' height='100%'>
                        </a>
                    </div>
                @elseif(isset($image->user->contact->name))
                    <a class='white' href=' {{ route('user.show', ['user' => $image->user->id]) }}'>
                        {{ $image->user->contact->name }}
                    </a>
                @else
                    membro da equipe excluído
                @endif
            </div>
            <div class='tb col-1'>
                {{ $image->status }}
            </div>
        </div>
    @endforeach
    <div class='row'>
        <div class='tb-footer'></div>
    </div>
    <br>
@endsection

@section('paginate', $images->links())
