@extends('layouts/index')

@section('title', 'IMAGENS')

@section('image-top')
    <i class="fas fa-image"></i>
@endsection


@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'image'" />
    <x-buttons.create model="image" :principalColor="$principalColor" />
@endsection

@section('filter')
    <x-table.filter :action="route('image.index')" :reset-url="route('image.index')" :total-filtered="$images->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome" />
        <x-filter.select name="type" :options="$types" placeholder="Todos os tipos" />
    </x-table.filter>
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
        <div class='row row-link' data-href="{{ route('image.show', ['image' => $image->id]) }}">
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

@section('pagination')
    <div class="mt-3">{{ $images->appends(request()->query())->links() }}</div>
@endsection
