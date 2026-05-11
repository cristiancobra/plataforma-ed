@extends('layouts/show')

@section('title', 'IMAGENS')

@section('image-top')
    <i class="fas fa-image"></i>
@endsection

@section('buttons')
    <x-buttons.trash :object="$image" model="image" />
    <x-buttons.edit model="image" :object="$image" />
    {{ createButtonList('image') }}
@endsection

@section('name', $image->name)

@section('status', $image->status)


@section('fieldsId')
    <div class="row">
        <div class='col-2 pe-0' style='text-align: center'>
            <div class='show-label'>
                ENVIADO POR
            </div>
        </div>
        <div class='col-4 ps-0' style='text-align: center'>
            @if ($image->contact_id != null or $image->contact_id != 0)
                <div class='show-field-end'>
                    <a class='white' href=' {{ route('contact.show', ['contact' => $image->contact_id]) }}'>
                        {{ $image->contact->name }}
                    </a>
                </div>
            @elseif(isset($image->user->image))
                <a href=' {{ route('user.show', ['user' => $image->user_id]) }}'>
                    <div class='show-field-end'>
                        {{ $image->user->contact->name }}
                    </div>
                </a>
            @else
                <div class='show-field-end'>
                    foi excluído
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-5">
        <div class='col-12 pe-0' style='text-align: center'>
            <div class='image-show'>
                <img src="{{ asset('storage/' . $image->path) }}"
                    style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="{{ $image->name }}">
            </div>
        </div>
    </div>
@endsection


@section('description')
    {!! html_entity_decode($image->alt) !!}
@endsection


@section('main')
@endsection

@section('deleteButton', route('image.destroy', ['image' => $image->id]))

@section('editButton', route('image.edit', ['image' => $image->id]))

@section('backButton', route('image.index'))

@section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{ date('d/m/Y H:i', strtotime($image->created_at)) }}
        </div>
    </div>
@endsection
