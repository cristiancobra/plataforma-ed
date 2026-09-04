@extends('layouts/master')

@section('title', 'EMPRÉSTIMOS')

@section('image-top')
    <i class="fa fa-exchange-alt"></i>
@endsection

@section('description')
    Criar novo empréstimo
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
            <strong><i class="fa fa-exclamation-triangle"></i> Erro ao criar o empréstimo:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div>
        <form action='{{ route('loan.store') }}' method='post'>
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <label class='labels' for='lender_user_id'>EMPRESTADOR (CREDOR):</label>
                    <select name="lender_user_id" id="lender_user_id" class="form-control" required>
                        <option value="">Selecione...</option>
                        @foreach ($lenderSelectOptions as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('lender_user_id', auth()->user()->id) == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('lender_user_id'))
                        <span class='text-danger'>{{ $errors->first('lender_user_id') }}</span>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class='labels'>TIPO DE DEVEDOR:</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="borrower_type" id="borrower_type_user"
                                value="user" {{ old('borrower_type', 'user') == 'user' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="borrower_type_user">
                                Usuário Interno
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="borrower_type" id="borrower_type_contact"
                                value="contact" {{ old('borrower_type') == 'contact' ? 'checked' : '' }}>
                            <label class="form-check-label" for="borrower_type_contact">
                                Contato Externo
                            </label>
                        </div>
                    </div>
                    @if ($errors->has('borrower_type'))
                        <span class='text-danger'>{{ $errors->first('borrower_type') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6" id="borrower_user_div"
                    style="{{ old('borrower_type', 'user') == 'user' ? '' : 'display:none;' }}">
                    <label class='labels' for='borrower_user_id'>DEVEDOR (USUÁRIO):</label>
                    <select name="borrower_user_id" id="borrower_user_id" class="form-control">
                        <option value="">Selecione...</option>
                        @foreach ($borrowerUserSelectOptions as $id => $name)
                            <option value="{{ $id }}" {{ old('borrower_user_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('borrower_user_id'))
                        <span class='text-danger'>{{ $errors->first('borrower_user_id') }}</span>
                    @endif
                </div>

                <div class="col-md-6" id="borrower_contact_div"
                    style="{{ old('borrower_type') == 'contact' ? '' : 'display:none;' }}">
                    <label class='labels' for='borrower_contact_id'>DEVEDOR (CONTATO):</label>
                    <select name="borrower_contact_id" id="borrower_contact_id" class="form-control">
                        <option value="">Selecione...</option>
                        @foreach ($borrowerContactSelectOptions as $id => $name)
                            <option value="{{ $id }}" {{ old('borrower_contact_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('borrower_contact_id'))
                        <span class='text-danger'>{{ $errors->first('borrower_contact_id') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for='start_date'>DATA DE EMPRÉSTIMO:</label>
                    <input type='date' name='start_date' id='start_date' class='form-control'
                        value='{{ old('start_date', date('Y-m-d')) }}' required>
                    @if ($errors->has('start_date'))
                        <span class='text-danger'>{{ $errors->first('start_date') }}</span>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class='labels' for='due_date'>DATA DE VENCIMENTO:</label>
                    <input type='date' name='due_date' id='due_date' class='form-control' value='{{ old('due_date') }}'
                        required>
                    @if ($errors->has('due_date'))
                        <span class='text-danger'>{{ $errors->first('due_date') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for='destination'>DESTINO:</label>
                    <input type='text' name='destination' id='destination' class='form-control'
                        value='{{ old('destination') }}' placeholder="Ex: Sala de reuniões, Evento X, Uso externo...">
                    @if ($errors->has('destination'))
                        <span class='text-danger'>{{ $errors->first('destination') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels'>ITENS DO ACERVO (Apenas itens físicos disponíveis):</label>
                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        @if ($availableCollections->count() > 0)
                            @foreach ($availableCollections as $collection)
                                <div class="form-check mb-2">
                                    <input class="form-check-input collection-checkbox" type="checkbox"
                                        name="collection_ids[]" value="{{ $collection->id }}"
                                        id="collection_{{ $collection->id }}"
                                        {{ is_array(old('collection_ids')) && in_array($collection->id, old('collection_ids')) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-between w-100"
                                        for="collection_{{ $collection->id }}">
                                        <span>
                                            <strong>{{ $collection->name }}</strong>
                                            @if ($collection->patrimony_number)
                                                - Pat: {{ $collection->patrimony_number }}
                                            @endif
                                        </span>
                                        <span class="text-muted small">
                                            {{ $collection->collectionType->name ?? 'Sem tipo' }}
                                        </span>
                                    </label>
                                </div>
                                <div class="condition-input mb-3" id="condition_div_{{ $collection->id }}"
                                    style="display:none; margin-left: 30px;">
                                    <label class='small' for='condition_{{ $collection->id }}'>Condição no
                                        empréstimo:</label>
                                    <textarea name="conditions[{{ $collection->id }}]" id="condition_{{ $collection->id }}"
                                        class='form-control form-control-sm' rows='2' placeholder="Ex: Em bom estado, com riscos leves...">{{ old('conditions.' . $collection->id) }}</textarea>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Nenhum item físico disponível para empréstimo no momento.</p>
                        @endif
                    </div>
                    @if ($errors->has('collection_ids'))
                        <span class='text-danger'>{{ $errors->first('collection_ids') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for='notes'>OBSERVAÇÕES:</label>
                    <textarea name='notes' id='notes' class='form-control' rows='4'>{{ old('notes') }}</textarea>
                    @if ($errors->has('notes'))
                        <span class='text-danger'>{{ $errors->first('notes') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('loan.index') }}" class="btn btn-secondary me-4">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn"
                        style="background-color: {{ $principalColor ?? '#007bff' }}; color: #fff;">
                        <i class="fa fa-save"></i> Criar Empréstimo
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Toggle entre usuário e contato
        document.querySelectorAll('input[name="borrower_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'user') {
                    document.getElementById('borrower_user_div').style.display = '';
                    document.getElementById('borrower_contact_div').style.display = 'none';
                    document.getElementById('borrower_user_id').required = true;
                    document.getElementById('borrower_contact_id').required = false;
                    document.getElementById('borrower_contact_id').value = '';
                } else {
                    document.getElementById('borrower_user_div').style.display = 'none';
                    document.getElementById('borrower_contact_div').style.display = '';
                    document.getElementById('borrower_user_id').required = false;
                    document.getElementById('borrower_contact_id').required = true;
                    document.getElementById('borrower_user_id').value = '';
                }
            });
        });

        // Mostrar/ocultar campo de condição quando item é selecionado
        document.querySelectorAll('.collection-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var conditionDiv = document.getElementById('condition_div_' + this.value);
                if (this.checked) {
                    conditionDiv.style.display = 'block';
                } else {
                    conditionDiv.style.display = 'none';
                }
            });

            // Exibir condições já marcadas (para old values)
            if (checkbox.checked) {
                document.getElementById('condition_div_' + checkbox.value).style.display = 'block';
            }
        });
    </script>
@endsection
