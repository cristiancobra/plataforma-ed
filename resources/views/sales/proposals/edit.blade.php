@extends('layouts/edit')

@if ($type == 'receita')
    @section('title', 'PROPOSTAS')
@else
    @section('title', 'DESPESAS')
@endif

@section('image-top')
    <i class="fas fa-box"></i>
@endsection

@section('form_start')
    <form id="proposal-form" action=' {{ route('proposal.update', ['proposal' => $proposal]) }} ' method='post'
        enctype='multipart/form-data'>
        @csrf
        @method('put')
    @endsection


    @section('buttons')
        <x-buttons.cancel :href="route('proposal.index', ['type' => $type])" />
        <x-buttons.save :principalColor="$principalColor" formId="proposal-form" />
    @endsection

    @section('name')
        NOME:
        <input type='text' name='name' size='60' style='margin-left: 10px' value='{{ $proposal->name }}'>
    @endsection


    @section('status')
        SITUAÇÃO:
        {{ createSimpleSelect('status', 'fields', $status, $proposal->status) }}
    @endsection

    @section('fieldsId')
        <div class='col-lg-2 col-xs-6' style='text-align: center'>
            <div class='show-label'>
                ORGANIZAÇÃO
            </div>
            <div class='show-label'>
                CONTATO
            </div>
            @if (isset($proposal->opportunity))
                <div class='show-label'>
                    OPORTUNIDADE
                </div>
            @endif
        </div>
        <div class='col-lg-4 col-xs-6' style='text-align: center'>
            <div class='show-field-end'>
                {{ createDoubleSelectIdName('company_id', 'fields', $companies, 'Não possui', $proposal->company) }}
            </div>
            <div class='show-field-end'>
                {{ createDoubleSelectIdName('contact_id', 'fields', $contacts, 'Não possui', $proposal->contact) }}
                {{ createButtonAdd('company.create', 'typeCompanies', 'fornecedor') }}
            </div>
            @if (isset($proposal->opportunity))
                <div class='show-field-end'>
                    <input type='hidden' name='opportunity_id' value='{{ $proposal->opportunity_id }}'>
                    <span class='fields'>{{ $proposal->opportunity->name }}</span>
                </div>
            @endif
        </div>
        <div class='col-lg-2 col-xs-6' style='text-align: center'>
            <div class='show-label'>
                RESPONSÁVEL
            </div>
            <div class='show-label'>
                IDENTIFICADOR
            </div>
            <div class='show-label'>
                CONTRATO
            </div>
            <div class='show-label'>
                PARCELAMENTO
            </div>
        </div>
        <div class='col-lg-4 col-xs-6' style='text-align: center'>
            <div class='show-field-end'>
                <select name='user_id' style='width: 89%'>
                    <option class='fields' value='{{ $proposal->user_id }}'>
                        {{ $proposal->user->contact->name }}
                    </option>
                    @foreach ($users as $user)
                        <option class='fields' value='{{ $user->id }}'>
                            {{ $user->contact->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class='show-field-end'>
                <input type='number' name='identifier' size='5' style='text-align: right'
                    value='{{ $proposal->identifier }}'>
            </div>
            <div class='show-field-end'>
                @if (!isset($proposal->contract_id) or $proposal->contract_id == 0)
                    Sem contrato
                @else
                    <select name='contract_id'>
                        <option class='fields' value='{{ $proposal->contract_id }}'>
                            {{ $proposal->contract_id }}
                        </option>
                        @foreach ($contracts as $contract)
                            <option class='fields' value='{{ $contract->id }}'>
                                {{ $contract->id }} - {{ $contract->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class='show-field-end'>
                <input type='number' class='fields' style='text-align: right' name='installment'
                    value='{{ $proposal->installment }}' max='12' size='4'>
            </div>
        </div>
    @endsection



    @section('date_start')
        <div class='circle-date-start'>
            <input type='date' name='date_creation' size='20' value='{{ $proposal->date_creation }}'>
            @if ($errors->has('date_creation'))
                <span class='text-danger'>{{ $errors->first('date_creation') }}</span>
            @endif
        </div>
        <p class='labels' style='text-align: center'>
            CRIAÇÃO
        </p>
    @endsection


    @section('date_due')
        <div class='circle-date-due'>
            <input type='date' name='pay_day' size='20' value='{{ $proposal->pay_day }}'>
            @if ($errors->has('pay_day'))
                <span class='text-danger'>{{ $errors->first('pay_day') }}</span>
            @endif
        </div>
        <p class='labels' style='text-align: center'>
            VENCIMENTO
        </p>
    @endsection


    @section('date_conclusion')
        <div class='circle-date-due'>
            <input type='number' name='expiration_date' size='3' min='1' max='365'
                value='{{ $proposal->expiration_date }}'> dias
        </div>
        <p class='labels' style='text-align: center'>
            VALIDADE
        </p>
    @endsection


    @section('description')
        <textarea id='description' name='description' rows='20' cols='90'>
		{{ $proposal->description }}
    </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script>
            Jodit.make('textarea[name=\"description\"]', { language: 'pt_BR' });
        </script>
    @endsection


    @section('main')
        <section class='container' id='productsProposals'>
            <div class='row mt-5'>
                <label class='labels' for=''>
                    PRODUTOS ATUAIS:
                </label>
            </div>
            <div class='row table-header mt-3'>
                <div class='col-1'>
                    FOTO
                </div>
                <div class='col-1'>
                    QTDE
                </div>
                <div class='col-3'>
                    NOME
                </div>
                <div class='col-1'>
                    HORAS
                </div>
                <div class='col-1'>
                    PONTOS
                </div>
                <div class='col-1'>
                    PRAZO
                </div>
                <div class='col-1'>
                    CUSTOS
                </div>
                <div class='col-1'>
                    IMPOSTO
                </div>
                <div class='col-1'>
                    UNITÁRIO
                </div>
                <div class='col-1'>
                    PREÇO
                </div>
            </div>

            @foreach ($productProposals as $productProposal)
                <input type='hidden' name='product_proposal_id[]' value='{{ $productProposal->id }}'>
                <input type='hidden' name='product_id[]' value='{{ $productProposal->product->id }}'>
                <input type='hidden' name='product_margin[]' size='7'
                    value='{{ (-$productProposal->product->price * $productProposal->product->tax_rate) / 100 - $productProposal->product->cost1 - $productProposal->product->cost2 - $productProposal->product->cost3 + $productProposal->product->price }}'>
                <input type='hidden' name='product_due_date[]' size='4'
                    value='{{ $productProposal->product->due_date }}'>
                <input type='hidden' name='product_work_hours[]' size='4'
                    value='{{ $productProposal->product->work_hours }}'>
                <input type='hidden' name='product_points[]' size='4'
                    value='{{ $productProposal->product->points }}'>
                <input type='hidden' name='product_cost[]' size='7'
                    value='{{ $productProposal->product->cost1 + $productProposal->product->cost2 + $productProposal->product->cost3 }}'>
                <input type='hidden' name='product_tax_rate[]' size='7'
                    value='{{ ($productProposal->product->price * $productProposal->product->tax_rate) / 100 }}'>
                <div class='row table2'
                    style='
             color: {{ $principalColor }};
             border-left-color: {{ $complementaryColor }}
             '>
                    <div class='cel col-1'>
                        <a class=''
                            href=' {{ route('product.show', ['product' => $productProposal->product_id]) }}'>
                            <image src='{{ $productProposal->product->image }}'
                                style='width:50px;height:50px; margin: 5px'>
                        </a>
                        </a>
                    </div>
                    <div class='cel col-1'>
                        <input style="text-align: right" type='number' name='product_amount[]' size='5'
                            value='{{ $productProposal->amount }}'>
                    </div>
                    <div class='cel col-3 justify-content-start'>
                        <a class=''
                            href=' {{ route('product.show', ['product' => $productProposal->product_id]) }}'>
                            <span class='fields'>
                                {{ $productProposal->product->name }}
                            </span>
                        </a>
                    </div>
                    <div class='cel col-1'>
                        {{ number_format($productProposal->product->due_date) }}
                    </div>
                    <div class='cel col-1'>
                        {{ number_format($productProposal->product->work_hours) }}
                    </div>
                    <div class='cel col-1'>
                        {{ number_format($productProposal->product->points) }}
                    </div>
                    <div class='cel col-1'>
                        {{ number_format($productProposal->product->cost1 + $productProposal->product->cost2 + $productProposal->product->cost3, 2, ',', '.') }}
                    </div>
                    <div class='cel col-1'>
                        {{ number_format(($productProposal->product->price * $productProposal->product->tax_rate) / 100, 2, ',', '.') }}
                    </div>
                    <div class='cel col-1'>
                        @if ($type == 'despesa')
                            <input type='decimal' name='price[]' id='product_price' class='prices' size='7'
                                onkeyup="formatCurrencyRealAll('input.prices')"
                                value='{{ formatCurrency($productProposal->price * -1) }}' style='text-align: right'>
                        @else
                            <input type='decimal' name='price[]' id='product_price' class='prices' size='7'
                                onkeyup="formatCurrencyRealAll('input.prices')"
                                value='{{ formatCurrency($productProposal->price) }}' style='text-align: right'>
                        @endif
                    </div>
                    <div class='cel col-1'>
                        {{ formatCurrencyReal($productProposal->subtotalPrice) }}
                    </div>
                </div>
            @endforeach
            <div class='row mt-1'>
                <div class='cel offset-8 col-2 table-header justify-content-end'
                    style="background-color: {{ $oppositeColor }}">
                    desconto:
                </div>
                <div class='cel col-2 justify-content-end' style='font-weight: 600;color:{{ $principalColor }}'>
                    <input type='text' id='discount' name='discount' onkeyup="formatCurrencyReal('discount')"
                        value='{{ formatCurrency($proposal->discount) }}' style='text-align: right;width: 90px'>
                </div>
            </div>
            <div class='row mt-1'>
                <div class='cel offset-8 col-2  table-header justify-content-end'>
                    TOTAL:
                </div>
                <div class='cel col-2 justify-content-end' style='font-weight: 600;color:{{ $principalColor }}'>
                    {{ formatCurrencyReal($proposal->totalPrice) }}
                </div>
            </div>
        </section>
    @endsection

    @section('attachments')
        @if ($type == 'despesa')
            {{-- ANEXOS EXISTENTES --}}
            @if (count($proposal->attachments ?? []) > 0)
                <section class='container' style='margin-top: 50px'>
                    <div class='row show-label-large col-12'>
                        <div class=''>
                            DOCUMENTOS ANEXADOS
                        </div>
                    </div>
                    <div class='row mt-3'>
                        @foreach ($proposal->attachments as $attachment)
                            <div class='col-md-6 mb-4'>
                                <div class="card p-3">
                                    <form action="{{ route('attachment.update', ['attachment' => $attachment->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row align-items-center">
                                            <div class="col-md-2 text-center">
                                                <i class="fa fa-file-invoice-dollar"
                                                    style="font-size: 48px; color:{{ $principalColor }}"></i>
                                            </div>

                                            <div class="col-md-10">
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label class='labels' style="font-size: 11px;">Tipo:</label>
                                                        <select name='type' class='form-control form-control-sm'
                                                            required>
                                                            <option value='Nota fiscal'
                                                                {{ $attachment->type == 'Nota fiscal' ? 'selected' : '' }}>
                                                                Nota fiscal</option>
                                                            <option value='Orçamento aprovado'
                                                                {{ $attachment->type == 'Orçamento aprovado' ? 'selected' : '' }}>
                                                                Orçamento aprovado</option>
                                                            <option value='Orçamento concorrente'
                                                                {{ $attachment->type == 'Orçamento concorrente' ? 'selected' : '' }}>
                                                                Orçamento concorrente</option>
                                                            <option value='Boleto'
                                                                {{ $attachment->type == 'Boleto' ? 'selected' : '' }}>
                                                                Boleto</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class='labels' style="font-size: 11px;">Data:</label>
                                                        <input type='date' name='created_at'
                                                            class='form-control form-control-sm'
                                                            value='{{ date('Y-m-d', strtotime($attachment->created_at)) }}'>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <label class='labels' style="font-size: 11px;">Nome do
                                                            arquivo:</label>
                                                        <input type='text' name='name'
                                                            class='form-control form-control-sm'
                                                            value='{{ $attachment->name }}' required>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-12 d-flex justify-content-end gap-2">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="if(confirm('Tem certeza que deseja excluir este documento?')) { document.getElementById('delete-form-{{ $attachment->id }}').submit(); }"
                                                            title="Excluir">
                                                            <i class="fa fa-trash"></i> Excluir
                                                        </button>
                                                        <a href="{{ asset('storage/' . $attachment->path) }}"
                                                            download="{{ $attachment->name }}"
                                                            class="btn btn-sm btn-secondary" title="Baixar">
                                                            <i class="fa fa-download"></i> Baixar
                                                        </a>
                                                        <button type="submit" class="btn btn-sm"
                                                            style="background-color: {{ $principalColor }}; color: white;"
                                                            title="Salvar">
                                                            <i class="fa fa-save"></i> Salvar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Form separado para delete --}}
                                    <form id="delete-form-{{ $attachment->id }}"
                                        action="{{ route('attachment.destroy', ['attachment' => $attachment->id]) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- FORMULÁRIO PARA ADICIONAR NOVOS ANEXOS --}}
            <section class='container' style='margin-top: 40px'>
                <div class='row show-label-large col-12'>
                    <div class='col-12'>
                        <h5 class='mb-3 text-white'>
                            <i class="fa fa-plus-circle me-2"></i>
                            ADICIONAR NOVO DOCUMENTO
                        </h5>
                    </div>
                </div>
                <form action="{{ route('attachment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

                    <div class='row mt-3'>
                        <div class='col-md-4'>
                            <label class='labels mb-2' for='attachment_type_edit'>Tipo de documento:</label>
                            <select id='attachment_type_edit' name='type' class='form-control' required>
                                <option value=''>Selecione o tipo</option>
                                <option value='Nota fiscal'>Nota fiscal</option>
                                <option value='Orçamento aprovado'>Orçamento aprovado</option>
                                <option value='Orçamento concorrente'>Orçamento concorrente</option>
                                <option value='Boleto'>Boleto</option>
                            </select>
                        </div>
                        <div class='col-md-4'>
                            <label class='labels mb-2' for='attachment_file_edit'>Selecione o arquivo PDF:</label>
                            <input type='file' id='attachment_file_edit' name='attachment' accept=".pdf"
                                class='form-control' required>
                        </div>
                        <div class='col-md-4'>
                            <button type="submit" class='btn w-100'
                                style="margin-top: 32px; background-color: {{ $principalColor }}; color: white;">
                                <i class="fa fa-upload me-2"></i> Enviar Documento
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        @endif
    @endsection
