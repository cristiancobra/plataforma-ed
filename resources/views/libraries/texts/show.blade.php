@extends('layouts/show')

@section('title', 'DOCUMENTOS')

@section('image-top')
    <i class="fa fa-file"></i>
@endsection

@section('buttons')
    <x-buttons.trash :object="$text" model="text" />
    <x-buttons.edit model="text" :object="$text" />
    {{ createButtonList('text') }}
@endsection

@section('name', $text->name)


@section('priority', $priority)


@section('status', $status)


@section('fieldsId')
    <div class="row">
        <div class='col-2 pe-0' style='text-align: center'>
            <div class='show-label'>
                RESPONSÁVEL
            </div>
        </div>
        <div class='col-4 ps-0' style='text-align: center'>

            @if (isset($text->user->contact->name))
                <a href=' {{ route('user.show', ['user' => $text->user_id]) }}'>
                    <div class='show-field-end'>
                        {{ $text->user->contact->name }}
                    </div>
                </a>
            @else
                <div class='show-field-end'>
                    foi excluído
                </div>
            @endif
        </div>

        <div class='col-2 pe-0' style='text-align: center'>
            <div class='show-label'>
                DEPARTAMENTO
            </div>
            <div class='show-label'>
                PÁGINAS
            </div>
        </div>
        <div class='col-4 ps-0' style='text-align: center'>
            <div class='show-field-end'>
                {{ $text->department }}
            </div>
            @if ($pages == null)
                <div class='show-field-end'>
                    não vinculado
                </div>
            @else
                @foreach ($pages as $page)
                    <a href=' {{ route('page.edit', ['page' => $page]) }}'>
                        <div class='show-field-end'>
                            {{ $page->name }}
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection


@section('description')
    <br>
    {!! html_entity_decode($text->title) !!}
    <br>
    <br>
    {!! html_entity_decode($text->text) !!}
    <br>
@endsection

@section('images')
    @if (count($text->images) > 0)
        <div class='show-label-large mt-5'>
            IMAGENS
        </div>
        <div class='description-field'>
            <div class="row">
                @foreach ($text->images as $image)
                    <div class='col'>
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->name }}"
                            style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection


@section('attachments')
    @if (count($text->attachments) > 0)
        <div class='show-label-large mt-5'>
            ANEXOS
        </div>
        <div class='description-field'>
            <div class="row">
                @foreach ($text->attachments as $attachment)
                    <div class='col-md-4 mb-3'>
                        <a href="{{ asset('storage/' . $attachment->path) }}" download="{{ $attachment->name }}"
                            class="text-decoration-none">
                            <div class="card text-center p-3 h-100">
                                <i class="fa fa-file-pdf text-danger" style="font-size: 48px;"></i>
                                <div class="mt-2">
                                    <strong>{{ $attachment->name }}</strong>
                                </div>
                                <small class="text-muted">Clique para baixar</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection


@section('editButton', route('text.edit', ['text' => $text->id]))

@section('backButton', route('text.index'))

@section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{ date('d/m/Y H:i', strtotime($text->created_at)) }}
        </div>
    </div>
@endsection
