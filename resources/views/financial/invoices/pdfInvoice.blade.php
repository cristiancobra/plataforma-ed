<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <!-- Styles -->
        <link href="{{public_path('css/pdf.css')}}" rel="stylesheet">
    </head>
    <body>
        <header style="background-color:{{$data['accountPrincipalColor']}}">
            <h1 style="float: left;vertical-align: super;color:white;line-height: 0.5;padding-top: 10px">
                FATURA {{$data['invoiceIdentifier']}}
                <br>
                <span style="font-size: 12px">Vencimento: {{date('d/m/Y', strtotime($data['invoicePayday']))}}</span>
            </h1>
            <img style='float: right' src='{{$data['accountLogo']}}' height='50px' width='150px'>
        </header>
        <footer style="background-color:{{$data['accountPrincipalColor']}}">
            CNPJ: {{formatCnpj($data['accountCnpj'])}}
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            EMAIL:{{$data['accountEmail']}}
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            <span style="font-weight: 900">&#183;</span>
            TEL:{{phoneBr($data['accountPhone'])}}
            <br>
            {{$data['accountAddress']}}   -   
            {{$data['accountCity']}} / 
            {{$data['accountState']}}
        </footer>
    <div>
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
            <td class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                QTDE
            </td>
            <td   class="table-list-header" style="width: 60%;background-color:{{$data['accountPrincipalColor']}}">
                NOME
            </td>
            <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                IMPOSTO
            </td>
            <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                UNITÁRIO
            </td>
            <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                TOTAL
            </td>
        </tr>

        @foreach ($data['invoiceLines'] as $invoiceLine)
        <tr style="font-size: 14px; width: 10%; text-align: center">
            <td class="table-list-center">
                {{$invoiceLine->amount }}
            </td>
            <td class="table-list-left">
                {{$invoiceLine->product->name}}
            </td>
            <td class="table-list-right">
                {{number_format($invoiceLine->subtotalTax_rate, 2,",",".")}}
            </td>
            <td class="table-list-right">
                {{number_format($invoiceLine->product->price,2,",",".")}}
            </td>
            <td class="table-list-right">
                {{number_format($invoiceLine->subtotalPrice,2,",",".")}}
            </td>
        </tr>
        <tr style="font-size: 12px">
            <td class="table-list-left" colspan="6">
                {!!html_entity_decode($invoiceLine->product->description)!!}
            </td>
        </tr>
        @endforeach

        <tr>
            <td   class="table-list-header-right" style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="3">
                desconto: 
            </td>
            <td   class="table-list-header-right" style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="2">
                - {{formatCurrencyReal($data['invoiceDiscount'])}}
            </td>
        </tr>
        <tr>
            <td   class="table-list-header-right"  style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="3">
                TOTAL: 
            </td>
            <td   class="table-list-header-right"   style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="2">
                {{formatCurrencyReal($data['invoiceTotalPrice'])}}
            </td>
        </tr>
    </tr>
    <tr>
        <td   class="table-list-header-right" style="background-color:{{$data['accountPrincipalColor']}}" colspan="3">
            PARCELAMENTO: 
        </td>
        <td   class="table-list-header-right" style="background-color:{{$data['accountPrincipalColor']}}" colspan="2">
            @if($data['invoiceNumberInstallmentTotal'] == 1)
            À vista
            @else
            {{$data['invoiceNumberInstallmentTotal']}} x {{formatCurrencyReal($data['invoiceInstallmentValue'])}}
            @endif
        </td>
    </tr>
</table>
<table  class="table-list" style="width: 100%;text-align:left">
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