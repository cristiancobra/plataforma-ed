<section class='container frame mt-5' id='transactions' style="border-color:{{$transactionFrameColor}}">
    <div class="row">
        <div class='col-10 pt-4 pb-3' style='font-size: 24px;padding-left: 5px;font-weight:600;color:{{$transactionFrameColor}}'>
            <i class="fa fa-receipt"></i>
            PAGAMENTOS
        </div>
        <div class='col-2 d-flex justify-content-end pt-4 pb-3 text-end' style='font-size: 16px;padding-left: 5px;font-weight:600;color:{{$transactionFrameColor}}'>
            <button id='paymentButtonOnOff' class='form-button' style="
                    color: {{$principalColor}};
                    background-color: {{$oppositeColor}};
                    border-color: {{$principalColor}};
                    " type='submit' title='ADICIONAR PAGAMENTO'>
                <i class="fa fa-money-bill"></i>
            </button>
        </div>
    </div>

    @if($transactions->isNotEmpty())

    <!--cabeçalho de faturas-->

    <div class="container" id="transactions-header">
        <div class='row table-header mt-3 mb-3'>
            <div   class='col-4'>
                ORIGEM
            </div>
            <div   class='col-2'>
                VENCIMENTO
            </div>
            <div   class='col-2'>
                VALOR
            </div>
        </div>
    </div>

    <!--linhas de  faturas-->
    <div class="container" id="transactions-lines">

        @foreach ($transactions as $transaction)
        <div class="row">
            <div class='col-10'>
                <div class='row table2 position-relative'  style='
                     color: {{$principalColor}};
                     border-left-color: {{$complementaryColor}};

                     '>
                    <a class='stretched-link' href="{{route('transaction.show', ['transaction' => $transaction])}}" style="color:white">
                    </a>
                    <div class='cel col-1 justify-content-start'  style="font-size: 26px;font-weight: 600">
                        {{$counterInvoices}}
                        <i class="fas fa-coins" style='
                           display:block;
                           padding-left:10px;
                           width:25%;
                           font-size: 30px;
                           '>
                        </i>
                    </div>
                    <div class='cel col-5 justify-content-start'>
                        {{$transaction->BankAccount->name}}
                    </div>
                    <div class='cel col-2 justify-content-center'>
                        {{date('d/m/Y', strtotime($transaction->pay_day))}}
                    </div>

                    <div class='cel col-2 justify-content-end'>
                        {{formatCurrencyReal($transaction->value)}}
                    </div>

                </div>
            </div>
            <div class='col-2 pt-4 d-flex justify-content-center'>
                @if($transaction->balance == $transaction->totalPrice)
                <a href='{{route('task.create')}}'>
                    <button class='form-button' style="
                            color: {{$principalColor}};
                            background-color: {{$oppositeColor}};
                            border-color: {{$principalColor}};
                            " type='' title='COBRAR'>
                        <i class="fa fa-bell"></i>
                    </button>
                </a>
                @else
                <a id='listPaymentsButtonOnOff_{{$counterInvoices}}'>
                    <button class='form-button' style="
                            color: {{$principalColor}};
                            background-color: {{$oppositeColor}};
                            border-color: {{$principalColor}};
                            " type='submit' title='VER PAGAMENTOS'>
                        <i class="fa fa-list"></i>
                    </button>
                </a>
                @endif

                @if($transaction->balance == 0)
                <p class="pt-2" id='{{$counterInvoices}}'>
                    {{faiconInvoiceStatus($transaction->status)}}
                </p>
                @else
                <a id='transactionPaymentButtonOnOff_{{$counterInvoices}}'>
                    <button class='form-button' style="
                            color: {{$principalColor}};
                            background-color: {{$oppositeColor}};
                            border-color: {{$principalColor}};
                            " type='submit' title='ADICIONAR PAGAMENTO'>
                        <i class="fa fa-money-bill"></i>
                    </button>
                </a>
                @endif
            </div>
        </div>

        <!--fim de transações-->
        @endforeach


        <!--  div oculta ADICIONAR TRANSACAO  -->

        <div class='container pt-5 pb-5' id='newPaymentRow' style='display: none;background-color: #f1f1f1'>
            <form id='addPayment' action='{{route('transaction.store', ['typeTransactions' => $type])}}' method='post' style='text-align: left'>
                @csrf
                <input type='hidden' name='invoice_id'  value='{{$invoice->id}}'>
                <div class="row mt-2">
                    <div class='col-3' style='text-align:left'>
                        <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                            REGISTRADO POR
                        </label>
                        <br>
                        {{createSelectUsers('select', $users)}}
                    </div>
                    <div class='col-3' style='text-align:left'>
                        <label class="labels" for="" >
                            CONTA:
                        </label>
                        <br>
                        <select name="bank_account_id">
                            @foreach ($bankAccounts as $bankAccount)
                            <option  class="fields" value="{{$bankAccount->id}}">
                                {{$bankAccount->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-2' style='text-align:left'>
                        <label class="labels" for="" >
                            DATA:
                        </label>
                        <br>
                        @if(!empty(app('request')->input('pay_day')))
                        <input type="date" name="pay_day" value="{{app('request')->input('pay_day')}}">
                        @else
                        <input type="date" name="pay_day" value="{{date('d-m-y')}}">
                        @endif
                        @if ($errors->has('pay_day'))
                        <span class="text-danger">{{$errors->first('pay_day')}}</span>
                        @endif
                    </div>
                    <div class='col-2' style='text-align:left'>
                        <label class='labels' for='priority' style='text-align:left;color:{{$principalColor}}'>
                            MEIO
                        </label>
                        <br>
                        {{createSimpleSelect('payment_method', 'fields', returnPaymentMethods())}}
                    </div>
                    <div class='col-1' style='text-align:left'>
                        <label class='labels' for='status' style='text-align:left;color:{{$principalColor}}'>
                            VALOR
                        </label>
                        <br>
                        @if ($errors->has('value'))
                        <span class="text-danger">{{$errors->first('value')}}</span>
                        @endif

                        @if($invoice->type == 'receita')
                        <input type="text" name="value" style="text-align: right" size='12' class='prices' onkeyup="formatCurrencyRealAll('input.prices')" value="{{formatCurrencyReal($invoice->totalPrice)}}">
                        @elseif($invoice->type == 'despesa')
                        <input type="text" name="value" style="text-align: right" size='12' class='prices' onkeyup="formatCurrencyRealAll('input.prices')" value="{{formatCurrencyReal($invoice->totalPrice * -1)}}">
                        @endif

                    </div>
                </div>
                <div class="row pt-4">
                    <div class='col-5' style='text-align:left'>
                        <label class='labels' for='description' style='text-align:left;color:{{$principalColor}}'>
                            OBSERVAÇÕES
                        </label>
                        @if ($errors->has('observations'))
                        <span class="text-danger">{{$errors->first('observations')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row pt-1">
                    <div class='col' style='text-align:left'>
                        <textarea id="" name="observations" rows="6" cols="90">
  {{old('observations')}}
                        </textarea>
                        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                        <script>
                            CKEDITOR.replace('observations');
                        </script>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class='col d-flex justify-content-end'>
                        {{createButtonSave()}}
                    </div>
                </div>
            </form>
        </div>
        <!--  FIM div oculta ADICIONAR transação  -->



    <!--    SALDO  e TOTAL-->
    <div class='row mt-4 mb-4'>
        <div class='offset-8 col-2 d-flex justify-content-end'>
            <div class='ellipse' style='color:{{$oppositeColor}}'>
                {{formatCurrencyReal($transactionsTotal)}}
            </div>
        </div>
        <div class='col-2 d-flex justify-content-end'>
            <div class='ellipse' style='color:{{$principalColor}}'>
                {{formatCurrencyReal($invoiceBalance)}}
            </div>
        </div>
    </div>
    
    </div>

    <!--mensagem sem transaçoes-->
    @else
    <div class='row mt-4 mb-4'>
        <div class='col d-flex justify-content-center'>
            Nenhuma movimentação registrada para esta fatura
        </div>
    </div>

    @endif


    <!--cabeçalho de faturas APAGADAS-->
    @if($deletedTransactions->isNotEmpty())
    <div class="container" id="invoices">
        <div class='row table-header mt-5 mb-3'  style="background-color: {{$oppositeColor}}">
            <div   class='col d-flex justify-content-start'>
                FATURA APAGADAS DESTA PROPOSTA
            </div>
        </div>
    </div>



    <!--linhas de  faturas APAGADAS -->

    <div class="container" id="deleted-invoices">
        @php
        $counterInvoices = 1;
        @endphp
        @foreach ($deletedTransactions as $deletedTransaction)
        <div class="row">
            <div class='col-10'>
                <div class='row table2 position-relative'  style='
                     color: {{$principalColor}};
                     border-left-color: {{$oppositeColor}};

                     '>
                    <a class='stretched-link' href="{{route('invoice.show', ['invoice' => $deletedTransaction])}}" style="color:white">
                    </a>
                    <div class='cel col-1 justify-content-start'  style="font-size: 26px;font-weight: 600">
                        <i class="fas fa-file-invoice-dollar" style='
                           display:block;
                           padding-left:10px;
                           width:25%;
                           font-size: 30px;
                           color: {{$oppositeColor}};
                           '>
                        </i>
                    </div>
                    <div class='cel col-4 justify-content-start'>
                        FATURA {{$deletedTransaction->identifier}}: parcela {{$deletedTransaction->number_installment}} de {{$invoice->installment}}
                    </div>
                    <div class='cel col-2'>
                        {{date('d/m/Y', strtotime($deletedTransaction->pay_day))}}
                    </div>

                    <div class='cel col-2 justify-content-end'>
                        {{formatCurrencyReal($deletedTransaction->totalPrice)}}
                    </div>


                    @if($deletedTransaction->balance < 0)
                    <div class='cel col-2 justify-content-end' style='color:red'>
                        {{formatCurrencyReal($deletedTransaction->balance)}}
                    </div>
                    @else
                    <div class='cel col-2 justify-content-end'>
                        {{formatCurrencyReal($deletedTransaction->balance)}}
                    </div>
                    @endif
                </div>
            </div>
            <div class='col-2 d-flex justify-content-center'>
                {{createButtonTrash($deletedTransaction, 'invoice')}}
            </div>
        </div>


        @php
        $counterTransactions = 1;
        @endphp
        <!--LINHA DE PAGAMENTOS / TRANSACTIONS apagadas-->
        <div id='paymentsRow_{{$counterInvoices++}}'  class='row' style="display:">
            @foreach($deletedTransaction->transactions as $transaction)
            @if($transaction->trash != 1)
            <div class="row">
                <div class='offset-1 col-9'>
                    <div class='row table2 position-relative'  style='
                         color: {{$principalColor}};
                         border-left-color: {{$oppositeColor}};
                         '>
                        <a class='stretched-link' href="{{route('transaction.show', ['transaction' => $transaction])}}" style="color:white">
                        </a>
                        <div class='cel col-1 justify-content-start'  style="font-size: 26px;font-weight: 600;color: {{$oppositeColor}}">
                            {{$counterTransactions++}}
                            <i class="fas fa-coins" style='
                               display:block;
                               padding-left:10px;
                               width:25%;
                               font-size: 30px;
                               color: {{$oppositeColor}};
                               '>
                            </i>
                        </div>
                        <div class='cel col-2'>
                            {{date('d/m/Y', strtotime($transaction->pay_day))}}
                        </div>
                        <div class='cel col-5 justify-content-start'>
                            {{$transaction->user->contact->name}}
                        </div>
                        <div class='cel col-2 justify-content-start'>
                            {{$transaction->bankAccount->name}}
                        </div>
                        <div class='cel col-2 justify-content-end'>
                            {{formatCurrencyReal($transaction->value)}}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <!--fim de transações apagadas-->

        @endforeach
    </div>
        @endif








</section>


<script>
            $('#paymentButtonOnOff').click(function () {
    $('#newPaymentRow').slideToggle(600);
    });
</script>