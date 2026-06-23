@extends('layouts/show')

@section('title', 'EMPRÉSTIMO')

@section('image-top')
    <i class="fa fa-exchange-alt"></i>
@endsection

@section('buttons')
    @if ($loan->status !== 'returned')
        <button type="button " class="btn text-white" style="background-color: {{ $principalColor }}" data-bs-toggle="modal"
            data-bs-target="#returnModal">
            <i class="fa fa-check"></i> REGISTRAR DEVOLUÇÃO
        </button>
    @endif
    <x-buttons.trash :object="$loan" model="loan" />
    <x-buttons.pdf :object="$loan" model="loan" :principalColor="$principalColor" />
    <x-buttons.edit model="loan" :object="$loan" :principalColor="$principalColor" />
    <x-buttons.list model="loan" :object="$loan" :principalColor="$principalColor" />
@endsection

@section('name', 'Empréstimo #' . $loan->id)

@section('status')
    @if ($loan->isOverdue())
        <span class="badge bg-danger fs-6">ATRASADO</span>
    @else
        @switch($loan->status)
            @case('pending')
                <span class="badge bg-secondary fs-6">PENDENTE</span>
            @break

            @case('active')
                <span class="badge bg-primary fs-6">ATIVO</span>
            @break

            @case('returned')
                <span class="badge bg-success fs-6">DEVOLVIDO</span>
            @break

            @case('cancelled')
                <span class="badge bg-dark fs-6">CANCELADO</span>
            @break
        @endswitch
    @endif
@endsection

@section('fieldsId')

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            EMPRESTADOR
        </div>
        <div class="col-4 border border-start-0 text-center py-2 ps-3">
            @if ($loan->lender && $loan->lender->contact)
                <a href="{{ route('user.show', $loan->lender->id) }}" class="text-decoration-none">
                    {{ $loan->lender->contact->name }}
                </a>
            @else
                {{ $loan->lender->name ?? '-' }}
            @endif
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            DEVEDOR
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            @if ($loan->borrower_user_id && $loan->borrowerUser)
                <a href="{{ route('user.show', $loan->borrowerUser->id) }}" class="text-decoration-none">
                    {{ $loan->borrowerUser->contact->name ?? $loan->borrowerUser->name }}
                </a>
            @elseif($loan->borrower_contact_id && $loan->borrowerContact)
                <a href="{{ route('contact.show', $loan->borrowerContact->id) }}" class="text-decoration-none">
                    {{ $loan->borrowerContact->name }}
                </a>
            @else
                -
            @endif
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            TIPO DEVEDOR
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            @if ($loan->getBorrowerType() === 'user')
                <span class="">Usuário Interno</span>
            @else
                <span class="">Contato Externo</span>
            @endif
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            DATA EMPRÉSTIMO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $loan->start_date->format('d/m/Y') }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            DATA VENCIMENTO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $loan->due_date->format('d/m/Y') }}
            @if ($loan->isOverdue())
                <span class="badge bg-danger ms-2">VENCIDO</span>
            @endif
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            DATA DEVOLUÇÃO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            @if ($loan->returned_date)
                {{ $loan->returned_date->format('d/m/Y') }}
            @else
                <span class="text-muted">Ainda não devolvido</span>
            @endif
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            QTDE ITENS
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $loan->loanItems->count() }}
            @if ($loan->loanItems->count() === 1)
                item
            @else
                itens
            @endif
        </div>
    </div>

    @if ($loan->notes)
        <div class="row g-0 mb-3">
            <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
                OBSERVAÇÕES
            </div>
            <div class="col-10 border border-start-0 py-2 px-3">
                {{ $loan->notes }}
            </div>
        </div>
    @endif

    <div class="row mt-4 mb-3">
        <div class="col-12">
            <h5 style="color: {{ $principalColor }}">
                <i class="fa fa-box"></i> Itens Emprestados
            </h5>
        </div>
    </div>

    @foreach ($loan->loanItems as $loanItem)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="card-title">
                            <a href="{{ route('collection.show', $loanItem->collection->id) }}"
                                class="text-decoration-none">
                                {{ $loanItem->collection->name }}
                            </a>
                        </h6>
                        <p class="card-text mb-1">
                            <strong>Tipo:</strong> {{ $loanItem->collection->collectionType->name ?? 'N/A' }}
                        </p>
                        @if ($loanItem->collection->patrimony_number)
                            <p class="card-text mb-1">
                                <strong>Patrimônio:</strong> {{ $loanItem->collection->patrimony_number }}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if ($loanItem->condition_on_loan)
                            <p class="mb-2">
                                <strong>Condição no empréstimo:</strong><br>
                                <span class="text-muted">{{ $loanItem->condition_on_loan }}</span>
                            </p>
                        @endif
                        @if ($loanItem->condition_on_return)
                            <p class="mb-2">
                                <strong>Condição na devolução:</strong><br>
                                <span class="text-muted">{{ $loanItem->condition_on_return }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

<!-- Modal para registrar devolução -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('loan.return', $loan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="background-color: {{ $principalColor }}; color: white;">
                    <h5 class="modal-title text-white" id="returnModalLabel">
                        <i class="fa fa-check"></i> Registrar Devolução
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Data de Devolução:</label>
                            <input type="date" name="returned_date" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6>Condição dos Itens na Devolução:</h6>
                        </div>
                    </div>

                    @foreach ($loan->loanItems as $loanItem)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">{{ $loanItem->collection->name }}</h6>
                                @if ($loanItem->condition_on_loan)
                                    <p class="text-muted small mb-2">
                                        <strong>Condição no empréstimo:</strong> {{ $loanItem->condition_on_loan }}
                                    </p>
                                @endif
                                <label class="form-label">Condição na devolução:</label>
                                <textarea name="conditions_on_return[{{ $loanItem->id }}]" class="form-control" rows="2"
                                    placeholder="Ex: Devolvido em perfeito estado, sem avarias...">{{ old('conditions_on_return.' . $loanItem->id) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Confirmar Devolução
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
