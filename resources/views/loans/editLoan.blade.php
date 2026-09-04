@extends('layouts/master')

@section('title', 'EMPRÉSTIMOS')

@section('image-top')
    <i class="fa fa-exchange-alt"></i>
@endsection

@section('description')
    Editar empréstimo #{{ $loan->id }}
@endsection

@section('buttons')
    <x-buttons.list model="loan" :principalColor="$principalColor ?? null" />
@endsection

@section('main')
    @if (Session::has('failed'))
        <div class='alert alert-danger'>
            {{ Session::get('failed') }}
            @php
                Session::forget('failed');
            @endphp
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-exclamation-triangle"></i> Erro ao atualizar o empréstimo:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div>
        <form action='{{ route('loan.update', $loan) }}' method='post'>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <label class='labels'>EMPRESTADOR (CREDOR):</label>
                    <input type="text" class="form-control"
                        value="{{ $loan->lender->contact->name ?? $loan->lender->name }}" readonly disabled>
                    <small class="text-muted">Não é possível alterar o emprestador</small>
                </div>

                <div class="col-md-6">
                    <label class='labels'>DEVEDOR:</label>
                    <input type="text" class="form-control" value="{{ $loan->getBorrowerName() }}" readonly disabled>
                    <small class="text-muted">Não é possível alterar o devedor</small>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels'>ITENS EMPRESTADOS:</label>
                    <div class="border rounded p-3">
                        @foreach ($loan->loanItems as $loanItem)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fa fa-box text-muted"></i>
                                        <strong>{{ $loanItem->collection->name }}</strong>
                                        @if ($loanItem->collection->patrimony_number)
                                            - Pat: {{ $loanItem->collection->patrimony_number }}
                                        @endif
                                    </span>
                                    <span
                                        class="badge bg-secondary">{{ $loanItem->collection->collectionType->name ?? 'Sem tipo' }}</span>
                                </div>
                                @if ($loanItem->condition_on_loan)
                                    <small class="text-muted ms-4">Condição no empréstimo:
                                        {{ $loanItem->condition_on_loan }}</small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Os itens não podem ser alterados após o empréstimo ser criado</small>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for='start_date'>DATA DE EMPRÉSTIMO:</label>
                    <input type='date' class='form-control' value='{{ $loan->start_date->format('Y-m-d') }}' readonly
                        disabled>
                    <small class="text-muted">Não é possível alterar a data de empréstimo</small>
                </div>

                <div class="col-md-6">
                    <label class='labels' for='due_date'>DATA DE VENCIMENTO:</label>
                    <input type='date' name='due_date' id='due_date' class='form-control'
                        value='{{ old('due_date', $loan->due_date->format('Y-m-d')) }}' required>
                    @if ($errors->has('due_date'))
                        <span class='text-danger'>{{ $errors->first('due_date') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for='destination'>DESTINO:</label>
                    <input type='text' name='destination' id='destination' class='form-control'
                        value='{{ old('destination', $loan->destination) }}'
                        placeholder="Ex: Sala de reuniões, Evento X, Uso externo...">
                    @if ($errors->has('destination'))
                        <span class='text-danger'>{{ $errors->first('destination') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for='notes'>OBSERVAÇÕES:</label>
                    <textarea name='notes' id='notes' class='form-control' rows='4'>{{ old('notes', $loan->notes) }}</textarea>
                    @if ($errors->has('notes'))
                        <span class='text-danger'>{{ $errors->first('notes') }}</span>
                    @endif
                </div>
            </div>

            @if ($loan->status !== 'returned')
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            <strong>Dica:</strong> Para registrar a devolução dos itens, acesse a página de detalhes do
                            empréstimo e use o botão "Registrar Devolução".
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Salvar Alterações
                    </button>
                    <a href="{{ route('loan.show', $loan) }}" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
