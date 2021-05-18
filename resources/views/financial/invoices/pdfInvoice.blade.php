<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <!-- Styles -->
        <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }

            .table-list-header {
                color:white;
                font-size: 14px;
                padding:8px;
                border-radius:20px;
                margin-top: 5px;
                margin-bottom: 5px;
                margin-left: 10px;
                margin-right: 10px;
            }

            .table-list {
                color:black;
                font-size: 12px;
                padding:8px;
                border-radius:20px;
                margin-top: 10px;
                margin-bottom: 5px;
                margin-left: 10px;
                margin-right: 10px;
            }
            
          .right {
                text-align: right;
            }
            .left {
                text-align: right;
            }
            .center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div style="margin-top: 20px">
            <h4 style="color:{{$data['accountPrincipalColor']}}">
                PARA:
            </h4>
            <!-- Dados do cliente--> 
            <p style="text-align: left">
                {{$data['customerName']}}
                <br>
                {{$data['companyName']}}
                @if(isset($data['companyCnpj']))
                <br>
                cnpj: {{formatCnpj($data['companyCnpj'])}}
                @endif
                @if(isset($data['companyEmail']))
                {{$data['companyEmail']}}
                @endif
                @if(isset($data['companyPhone']))
                {{$data['companyPhone']}}
                @endif
                @if(isset($data['companyAddress']))
                <br>
                {{$data['companyAddress']}}
                <br>
                {{$data['companyCity']}} / 
                {{$data['companyState']}} -
                {{$data['companyCountry']}}
                @endif
            </p>
        </div>
        <br>
        <h4 style="color:{{$data['accountPrincipalColor']}}">
            DESCRIÇÃO:
        </h4>
        <p style="text-align: left;margin-top: 0px;">
            {!!html_entity_decode($data['opportunityDescription'])!!}
        </p>
        <table  class="table-list" style="width: 100%">
            <tr>
                <td class="table-list-header center" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    QTDE
                </td>
                <td   class="table-list-header center" style="width: 60%;background-color:{{$data['accountPrincipalColor']}}">
                    NOME
                </td>
                <td   class="table-list-header center" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    IMPOSTO
                </td>
                <td   class="table-list-header center" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    UNITÁRIO
                </td>
                <td   class="table-list-header center" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    TOTAL
                </td>
            </tr>

            @foreach ($data['invoiceLines'] as $invoiceLine)
            <tr style="font-size: 14px; width: 10%; text-align: center">
                <td class="table-list center">
                    {{$invoiceLine->amount }}
                </td>
                <td class="table-list left">
                    {{$invoiceLine->product->name}}
                </td>
                <td class="table-list right">
                    {{number_format($invoiceLine->subtotalTax_rate, 2,",",".")}}
                </td>
                <td class="table-list right">
                    {{number_format($invoiceLine->product->price,2,",",".")}}
                </td>
                <td class="table-list right">
                    {{number_format($invoiceLine->subtotalPrice,2,",",".")}}
                </td>
            </tr>
            <tr style="font-size: 14px">
                <td class="table-list left" colspan="6">
                    {!!html_entity_decode($invoiceLine->product->description)!!}
                </td>
            </tr>
            @endforeach

            <tr>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="3">
                    desconto: 
                </td>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="2">
                    - {{formatCurrencyReal($data['invoiceDiscount'])}}
                </td>
            </tr>

            @if($data['invoiceTotalTransactions'])
            <tr>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="3">
                    pagamentos: 
                </td>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="2">
                    - {{formatCurrencyReal($data['invoiceTotalTransactions'])}}
                </td>
            </tr>
            @endif

            <tr>
                <td   class="table-list-header right"  style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="3">
                    TOTAL: 
                </td>
                <td   class="table-list-header right"   style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="2">
                    {{formatCurrencyReal($data['invoiceTotalPrice'] - $data['invoiceDiscount'] - $data['invoiceTotalTransactions'])}}
                </td>
            </tr>
            @if($data['invoiceStatus'] == 'rascunho' OR $data['invoiceStatus'] == 'orçamento')
            <tr>
                <td   class="table-list-header right" style="background-color:{{$data['accountPrincipalColor']}}" colspan="3">
                    PARCELAMENTO: 
                </td>
                <td   class="table-list-header right" style="background-color:{{$data['accountPrincipalColor']}}" colspan="2">
                    @if($data['invoiceNumberInstallmentTotal'] == 1)
                    À vista
                    @else
                    {{$data['invoiceNumberInstallmentTotal']}} x {{formatCurrencyReal($data['invoiceInstallmentValue'])}}
                    @endif
                </td>
                @endif
            </tr>
        </table>
        <br>
        <table  class="table-list" style="width: 100%;text-align:left">
            @if($data['invoiceDescription'])
            <tr>
                <td>
                    <h4 style="margin-bottom: 0px;color:{{$data['accountPrincipalColor']}}">
                        OBSERVAÇÕES:
                    </h4>
                    <p>
                        {!!html_entity_decode($data['invoiceDescription'])!!}
                    </p>
                    <br>
                    <hr>
                </td>
            </tr>
            @endif
            <tr>
                <td>
                    <h4 style="margin-bottom: 0px;color:{{$data['accountPrincipalColor']}}">
                        FORMAS DE PAGAMENTO:
                    </h4>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        À  VISTA: por boleto ou transferência bancária
                        <br>
                        PARCELADO: no cartão de crédito em até 12x
                        <br>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="color:{{$data['accountPrincipalColor']}}">
                        DADOS PARA PAGAMENTO:
                    </h4>
                </td>
            </tr>
            @foreach ($data['bankAccounts'] as $bankAccount)
            <tr>
                <td>
                    <p>
                        {{$bankAccount->bank->name}} - cód. {{$bankAccount->bank->bank_code}}
                        <br>
                        Agência: {{$bankAccount->agency}}
                        <br>
                        Conta: {{$bankAccount->account_number}}
                        @if($bankAccount->pix)
                        <br>
                        Chave PIX: {{$bankAccount->pix}}
                        @endif
                        <br>
                        CNPJ: {{$data['accountCnpj']}}
                    </p>
                </td>
            </tr>
            @endforeach			
        </table>
        <br>
        <br>
    </body>
</html>