@extends('layouts/master')

@section('title', $title)

@section('image-top')
    <i class="fa fa-bullseye"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model='opportunity' :principalColor=$principalColor ?? null />
@endsection

@section('main')
    @if (Session::has('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
            @php
                Session::forget('failed');
            @endphp
        </div>
    @endif
    <div class="mt-5 mb-5">
        <form action="{{ route('opportunity.store') }}" method="post" style="color: #874983">
            @csrf
            @if ($department == 'desenvolvimento')
                <input type="hidden" name="department" value="{{ $department }}">
            @endif
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">NOME:</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger small">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
            @if ($department == 'desenvolvimento')
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">METAS:</label>
                        {{ createSelectIdName('goal', 'fields', $goals, 'Não possui') }}
                    </div>
                </div>
            @endif
            <div class="row mb-3  mt-5 mb-5">
                <div class="col-md-4">
                    <label class="form-label">RESPONSÁVEL:</label>
                    {{ createSelectUsers('fields', $users) }}
                </div>
                @if ($department != 'desenvolvimento')
                    <div class="col-md-4">
                        <label class="form-label">ORGANIZAÇÃO:</label>
                        {{ createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física') }}
                        {{ createButtonAdd('company.create', 'typeCompanies', 'cliente') }}
                    </div>
                @endif

                <div class="col-md-4">
                    <label class="form-label">CONTATO:</label>
                    @if (!empty(app('request')->input('contact_id')))
                        <input type="hidden" name="contact_id" value="{{ app('request')->input('contact_id') }}">
                        {{ app('request')->input('contact_name') }}
                    @else
                        {{ createDoubleSelectIdName('contact_id', 'fields', $contacts) }}
                    @endif
                    {{ createButtonAdd('contact.create') }}
                </div>
            </div>
            <div class="row mb-3  mt-5 mb-5">
                <div class="col-md-4">
                    <label class="form-label">DATA DE CRIAÇÃO:</label>
                    <input type="date" class="form-control" name="date_start" value="{{ old('date_start') }}">
                    @if ($errors->has('date_start'))
                        <span class="text-danger small">{{ $errors->first('date_start') }}</span>
                    @endif
                </div>
                <div class="col-md-4">
                    <label class="form-label">PRAZO FINAL:</label>
                    <input type="date" class="form-control" name="date_due" value="{{ old('date_due') }}">
                    @if ($errors->has('date_due'))
                        <span class="text-danger small">{{ $errors->first('date_due') }}</span>
                    @endif
                </div>
                <div class="col-md-4">
                    <label class="form-label">DATA DA CONCLUSÃO:</label>
                    <input type="date" class="form-control" name="date_conclusion" value="{{ old('date_conclusion') }}">
                    @if ($errors->has('date_conclusion'))
                        <span class="text-danger small">{{ $errors->first('date_conclusion') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">DESCRIÇÃO:</label>
                    @if ($errors->has('description'))
                        <span class="text-danger small">{{ $errors->first('description') }}</span>
                    @endif
                    <textarea id="description" name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                </div>
            </div>
            <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('description');
            </script>
            <div class="row mb-3  mt-5 mb-5">
                @if ($stages != null)
                    <div class="col-md-6">
                        <label class="form-label">ETAPA:</label>
                        {{ createSimpleSelect('stage', 'fields', $stages) }}
                    </div>
                @endif
                <div class="col-md-6">
                    <label class="form-label">SITUAÇÃO:</label>
                    {{ createSimpleSelect('status', 'fields', $status) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-end">
                    <input class="btn text-white" style="background-color: {{ $principalColor }}" type="submit"
                        value="CRIAR">
                </div>
            </div>
        </form>
    </div>
@endsection
