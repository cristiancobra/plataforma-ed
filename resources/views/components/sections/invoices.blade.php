<x-show.section title="FATURAS" icon="fa fa-file-invoice-dollar" id="invoices" :color="$invoiceFrameColor">
    <x-slot:actions>
            @if ($proposal == null)
                <i class='fas fa-ban ms-2' style='font-size:28px'></i>
            @elseif($invoicesCount < 1)
                <x-buttons.icon-form icon="fas fa-file-invoice-dollar" title="Gerar faturas dos pagamentos"
                    :action="route('proposal.generateInstallment', ['proposal' => $proposal])" :principalColor="$principalColor" />
            @else
                <x-buttons.icon-form icon="fa fa-trash" color="#dc3545" title="Apagar TODAS as faturas"
                    :action="route('proposal.trashInvoices', ['proposal' => $proposal])"
                    confirm="Tem certeza que deseja apagar TODAS as faturas desta proposta?"
                    confirm-title="Apagar faturas" confirm-label="Apagar faturas" />
                <x-buttons.icon icon="fa fa-edit" title="Editar TODAS as faturas"
                    :href="route('proposal.editInstallment', ['proposal' => $proposal])" :principalColor="$principalColor" />
            @endif
    </x-slot:actions>

    @if ($proposal)
        @php
            $proposalBalance = $proposal->totalPrice - $invoicesPaidTotal;
        @endphp
        <div class="row mt-1 mb-3 text-center">
            <div class='col-4'>
                <div style="font-size: 13px;font-weight:600;color:{{ $complementaryColor }}">
                    TOTAL DE FATURAS
                </div>
                <div style='font-size: 20px;font-weight: 600;color:{{ $principalColor }}'>
                    {{ formatCurrencyReal($invoicesTotal) }}
                </div>
            </div>
            <div class='col-4'>
                <div style="font-size: 13px;font-weight:600;color:{{ $complementaryColor }}">
                    TOTAL PAGO
                </div>
                <div style='font-size: 20px;font-weight: 600;color:{{ $principalColor }}'>
                    {{ formatCurrencyReal($invoicesPaidTotal) }}
                </div>
            </div>
            <div class='col-4'>
                <div style="font-size: 13px;font-weight:600;color:{{ $complementaryColor }}">
                    SALDO A PAGAR
                </div>
                <div
                    style='font-size: 20px;font-weight: 600;color:{{ $proposalBalance < 0 ? 'red' : $principalColor }}'>
                    {{ formatCurrencyReal($proposalBalance) }}
                </div>
            </div>
        </div>
    @endif

    <!--cabeçalho de faturas-->

    <div class="row" id="invoices-header">
        <div class='col-10'>
            <x-table.header :background-color="$principalColor" class="mt-3 mb-3" :columns="[
                ['label' => '#', 'class' => 'col-1'],
                ['label' => 'FATURA', 'class' => 'col-4'],
                ['label' => 'VENCIMENTO', 'class' => 'col-2'],
                ['label' => 'VALOR', 'class' => 'col-2'],
                ['label' => 'SALDO', 'class' => 'col-2'],
            ]" />
        </div>
    </div>

    <!--linhas de  faturas-->
    <div id="invoices-lines">

        @foreach ($invoices as $invoice)
            <div class="row">
                <div class='col-10'>
                    <div class='row row-link border-bottom py-2 align-items-center'
                        data-href="{{ route('invoice.show', ['invoice' => $invoice]) }}">
                        <div class='col-1 fw-bold'>{{ $counterInvoices }}</div>
                        <div class='col-4 small'>
                            FATURA {{ $invoice->identifier }}: parcela {{ $invoice->number_installment }} de {{ $proposal->installment }}
                        </div>
                        <div class='col-2 text-center small'>{{ dateBr($invoice->pay_day) }}</div>
                        <div class='col-2 text-end small'>{{ formatCurrencyReal($invoice->totalPrice) }}</div>
                        <div class='col-2 text-end small {{ $invoice->balance < 0 ? 'text-danger' : '' }}'>
                            {{ formatCurrencyReal($invoice->balance) }}
                        </div>
                    </div>
                </div>
                <div class='col-2 d-flex justify-content-center align-items-center gap-1'>
                    @if ($invoice->balance == $invoice->totalPrice)
                        <x-buttons.icon icon="fa fa-bell" title="Cobrar" :href="route('task.create')" :principalColor="$principalColor" />
                    @else
                        <x-buttons.toggle id="listPaymentsButtonOnOff_{{ $counterInvoices }}" icon="fa fa-list"
                            title="Ver pagamentos" :principalColor="$principalColor" />
                    @endif

                    @if ($invoice->balance == 0)
                        <span id='{{ $counterInvoices }}'>
                            {{ faiconInvoiceStatus($invoice->status) }}
                        </span>
                    @else
                        <x-buttons.toggle id="invoicePaymentButtonOnOff_{{ $counterInvoices }}" icon="fa fa-money-bill"
                            title="Adicionar pagamento" :principalColor="$principalColor" />
                    @endif
                </div>
            </div>


            <!--  div oculta ADICIONAR PAGAMENTO  -->

            <div class='px-3 pt-5 pb-5' id='newPaymentRow_{{ $counterInvoices }}'
                style='display: none;background-color: #f1f1f1'>
                <form id='addPayment'
                    action='{{ route('transaction.store', ['typeTransactions' => $proposal->transactionType]) }}'
                    method='post' style='text-align: left'>
                    @csrf
                    <input type='hidden' name='invoice_id' value='{{ $invoice->id }}'>
                    <div class="row mt-2">
                        <div class='col-3' style='text-align:left'>
                            <label class='labels' for='user_id'
                                style='text-align:left;color:{{ $principalColor }}'>
                                REGISTRADO POR
                            </label>
                            <br>
                            {{ createSelectUsers('select', $users) }}
                        </div>
                        <div class='col-3' style='text-align:left'>
                            <label class="labels" for="">
                                CONTA:
                            </label>
                            <br>
                            <select name="bank_account_id">
                                @foreach ($bankAccounts as $bankAccount)
                                    <option class="fields" value="{{ $bankAccount->id }}">
                                        {{ $bankAccount->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-2' style='text-align:left'>
                            <label class="labels" for="">
                                DATA:
                            </label>
                            <br>
                            @if (!empty(app('request')->input('pay_day')))
                                <input type="date" name="pay_day" value="{{ app('request')->input('pay_day') }}">
                            @else
                                <input type="date" name="pay_day" value="{{ date('d-m-y') }}">
                            @endif
                            @if ($errors->has('pay_day'))
                                <span class="text-danger">{{ $errors->first('pay_day') }}</span>
                            @endif
                        </div>
                        <div class='col-2' style='text-align:left'>
                            <label class='labels' for='priority'
                                style='text-align:left;color:{{ $principalColor }}'>
                                MEIO
                            </label>
                            <br>
                            {{ createSimpleSelect('payment_method', 'fields', returnPaymentMethods()) }}
                        </div>
                        <div class='col-1' style='text-align:left'>
                            <label class='labels' for='status'
                                style='text-align:left;color:{{ $principalColor }}'>
                                VALOR
                            </label>
                            <br>
                            @if ($errors->has('value'))
                                <span class="text-danger">{{ $errors->first('value') }}</span>
                            @endif

                            @if ($proposal->type == 'receita')
                                <input type="text" name="value" style="text-align: right" size='12'
                                    class='prices' onkeyup="formatCurrencyRealAll('input.prices')"
                                    value="{{ formatCurrencyReal($invoice->totalPrice) }}">
                            @elseif($proposal->type == 'despesa')
                                <input type="text" name="value" style="text-align: right" size='12'
                                    class='prices' onkeyup="formatCurrencyRealAll('input.prices')"
                                    value="{{ formatCurrencyReal($invoice->totalPrice * -1) }}">
                            @endif

                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class='col-5' style='text-align:left'>
                            <label class='labels' for='description'
                                style='text-align:left;color:{{ $principalColor }}'>
                                OBSERVAÇÕES
                            </label>
                            @if ($errors->has('observations'))
                                <span class="text-danger">{{ $errors->first('observations') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row pt-1">
                        <div class='col' style='text-align:left'>
                            <textarea id="" name="observations" rows="6" cols="90">
  {{ old('observations') }}
                        </textarea>
                            <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                            <script>
                                Jodit.make('textarea[name=\"observations\"]', {
                                    language: 'pt_BR'
                                });
                            </script>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class='col d-flex justify-content-end'>
                            {{ createButtonSave() }}
                        </div>
                    </div>
                </form>
            </div>
            <!--  FIM div oculta ADICIONAR PAGAMENTO  -->

            @php
                $counterTransactions = 1;
            @endphp
            <!--LINHA DE PAGAMENTOS / TRANSACTIONS-->
            <div id='paymentsRow_{{ $counterInvoices++ }}' class='row' style="display:block">
                @foreach ($invoice->transactions as $transaction)
                    @if ($transaction->trash != 1)
                        <div class="row">
                            <div class='offset-1 col-9'>
                                <div class='row table2 position-relative'
                                    style='
                         color: {{ $principalColor }};
                         border-left-color: {{ $complementaryColor }};
                         '>
                                    <a class='stretched-link'
                                        href="{{ route('transaction.show', ['transaction' => $transaction]) }}"
                                        style="color:white">
                                    </a>
                                    <div class='cel col-1 justify-content-start'
                                        style="font-size: 26px;font-weight: 600">
                                        {{ $counterTransactions++ }}
                                        <i class="fas fa-coins"
                                            style='
                               display:block;
                               padding-left:10px;
                               width:25%;
                               font-size: 30px;
                               '>
                                        </i>
                                    </div>
                                    <div class='cel col-2'>
                                        {{ date('d/m/Y', strtotime($transaction->pay_day)) }}
                                    </div>
                                    <div class='cel col-5 justify-content-start'>
                                        {{ optional($transaction->user->contact ?? null)->name }}
                                    </div>
                                    <div class='cel col-2 justify-content-start'>
                                        {{ optional($transaction->bankAccount)->name }}
                                    </div>
                                    <div class='cel col-2 justify-content-end'>
                                        {{ formatCurrencyReal($transaction->value) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!--fim de transações-->
        @endforeach
    </div>







    <!--cabeçalho de faturas APAGADAS-->

    <div class="" id="invoices">
        <div class='row table-header mt-5 mb-3' style="background-color: {{ $complementaryColor }}">
            <div class='col d-flex justify-content-start'>
                FATURAS APAGADAS DESTA PROPOSTA
            </div>
        </div>
    </div>



    <!--linhas de  faturas APAGADAS -->

    <div class="" id="deleted-invoices">
        @php
            $counterInvoices = 1;
        @endphp
        @foreach ($deletedInvoices as $deletedInvoice)
            <div class="row">
                <div class='col-10'>
                    <div class='row row-link border-bottom py-2 align-items-center'
                        data-href="{{ route('invoice.show', ['invoice' => $deletedInvoice]) }}">
                        <div class='col-1 fw-bold'></div>
                        <div class='col-4 small'>
                            FATURA {{ $deletedInvoice->identifier }}: parcela {{ $deletedInvoice->number_installment }} de {{ $proposal->installment }}
                        </div>
                        <div class='col-2 text-center small'>{{ dateBr($deletedInvoice->pay_day) }}</div>
                        <div class='col-2 text-end small'>{{ formatCurrencyReal($deletedInvoice->totalPrice) }}</div>
                        <div class='col-2 text-end small {{ $deletedInvoice->balance < 0 ? 'text-danger' : '' }}'>
                            {{ formatCurrencyReal($deletedInvoice->balance) }}
                        </div>
                    </div>
                </div>
                <div class='col-2 d-flex justify-content-center'>
                    <x-buttons.trash :object="$deletedInvoice" model="invoice" />
                </div>
            </div>


            @php
                $counterTransactions = 1;
            @endphp
            <!--LINHA DE PAGAMENTOS / TRANSACTIONS-->
            <div id='paymentsRow_{{ $counterInvoices++ }}' class='row' style="display:">
                @foreach ($deletedInvoice->transactions as $transaction)
                    @if ($transaction->trash != 1)
                        <div class="row">
                            <div class='offset-1 col-9'>
                                <div class='row table2 position-relative'
                                    style='
                         color: {{ $principalColor }};
                         border-left-color: {{ $complementaryColor }};
                         '>
                                    <a class='stretched-link'
                                        href="{{ route('transaction.show', ['transaction' => $transaction]) }}"
                                        style="color:white">
                                    </a>
                                    <div class='cel col-1 justify-content-start'
                                        style="font-size: 26px;font-weight: 600;color: {{ $complementaryColor }}">
                                        {{ $counterTransactions++ }}
                                        <i class="fas fa-coins"
                                            style='
                               display:block;
                               padding-left:10px;
                               width:25%;
                               font-size: 30px;
                               color: {{ $complementaryColor }};
                               '>
                                        </i>
                                    </div>
                                    <div class='cel col-2'>
                                        {{ date('d/m/Y', strtotime($transaction->pay_day)) }}
                                    </div>
                                    <div class='cel col-5 justify-content-start'>
                                        {{ optional($transaction->user->contact ?? null)->name }}
                                    </div>
                                    <div class='cel col-2 justify-content-start'>
                                        {{ optional($transaction->bankAccount)->name }}
                                    </div>
                                    <div class='cel col-2 justify-content-end'>
                                        {{ formatCurrencyReal($transaction->value) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!--fim de transações-->
        @endforeach
    </div>

</x-show.section>


<script>
    @php
        $counterJs = 1;
        foreach ($invoices as $invoice) {
            echo "
            (function () {
                var btn = document.getElementById('invoicePaymentButtonOnOff_$counterJs');
                var row = document.getElementById('newPaymentRow_$counterJs');
                if (btn && row) {
                    btn.addEventListener('click', function () {
                        row.style.display = (row.style.display === 'none' || row.style.display === '') ? 'block' : 'none';
                    });
                }
            })();
            ";

            echo "
            (function () {
                var btn = document.getElementById('listPaymentsButtonOnOff_$counterJs');
                var row = document.getElementById('paymentsRow_$counterJs');
                if (btn && row) {
                    btn.addEventListener('click', function () {
                        row.style.display = (row.style.display === 'none' || row.style.display === '') ? 'block' : 'none';
                    });
                }
            })();
            ";
            $counterJs++;
        }
    @endphp
</script>
