<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <!-- Styles -->
        <style>
            * {
                font-family: Nunito, helvetica, sans-serif;
            }
            .break{
                page-break-after: always;
            }
            .p {
                
            }
            .header2 {
                color:white;
                text-align: left;
                font-size: 25px;
                padding-top:0px;
                padding-left:25px;
                border-radius:20px;
                background-color: grey;
                height: 80px;
            }
            .table-list-header {
                color:white;
                font-size: 14px;
                padding:8px;
                border-radius:10px;
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .table-list {
                color:black;
                font-size: 14px;
                font-weight: 600;
                padding-top:20px;
                padding-bottom: 10px;
                margin-top: 10px;
                margin-bottom: 5px;
                margin-left: 10px;
                margin-right: 10px;
                border-style: solid;
                border-bottom-width: 1px;
            }
            .toDo{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #F2E28C;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }
            .done{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #A5D9CC;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }

            .doing{
                display: table-cell;
                text-align: center;
                font-size: 14px;
                text-shadow: 2px 2px 4px #000000;
                color: white;
                vertical-align:middle;
                background-color: #92C4D4;
                border-style: solid;
                border-width: 1px; 
                border-color: white;
                border-radius:10px;
            }
            .description {
                color:black;
                font-size: 12px;
                padding:8px;
                padding-left:30px;
                margin-top: 0px;
                margin-bottom: 5px;
                margin-left: 40px;
                margin-right: 10px;
                border-radius:20px;
                border-style: solid;
                border-color: black;
                border-bottom: 1px;
                font-style: italic;
            }
            .right {
                text-align: right;
            }
            .left {
                text-align: left;
            }
            .center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <br>
        <br>
        <h3 style="text-align: center">
            Objeto do contrato
        </h3>
        <p>
            1. É objeto deste contrato o/a {{$data['contractName']}} nos termos aqui descritos.
        </p>
        <br>
        <h3 style="text-align: center">
            Identificação das partes
        </h3>
        <p>
            2. São partes deste contrato a empresa contratada 
            <span class="labels">{{$data['accountName']}}</span>
            inscrita no CNPJ sob o nº
            <span class="labels">{{$data['accountCnpj']}}</span>.
            Localizada na
            <span class="labels">{{$data['accountAddress']}}</span>,
            em
            <span class="labels">{{$data['accountCity']}}</span>,
            –
            <span class="labels">{{$data['accountState']}}</span>,
            CEP
            <span class="labels">{{$data['accountZipCode']}}</span>,
            representada por
            <span class="labels">{{$data['userName']}}</span>,
            inscrito no CPF sob o nº
            <span class="labels">{{$data['userCpf']}}</span>,
            residente em
            <span class="labels">{{$data['userAddress']}}</span>,
            em
            <span class="labels">{{$data['userCity']}}</span>,
            /
            <span class="labels">{{$data['userState']}}</span>,
            CEP:
            <span class="labels">{{formatZipCode($data['userZipCode'])}}</span> e,
        </p>
        <p>
            a empresa contratante
            <span class="labels">{{$data['companyName']}}</span>
            inscrita no CNPJ sob o nº
            <span class="labels">{{$data['companyCnpj']}}</span>.
            Localizada na
            <span class="labels">{{$data['companyAddress']}}</span>,
            em
            <span class="labels">{{$data['companyCity']}}</span>,
            –
            <span class="labels">{{$data['companyState']}}</span>,
            CEP
            <span class="labels">{{$data['companyZipCode']}}</span>,
            representada por
            <span class="labels">{{$data['contactName']}}</span>,
            inscrito no CPF sob o nº
            <span class="labels">{{$data['contactCpf']}}</span>,
            residente em
            <span class="labels">{{$data['contactAddress']}}</span>,
            em
            <span class="labels">{{$data['contactCity']}}</span>,
            /
            <span class="labels">{{$data['contactState']}}</span>,
            CEP:
            <span class="labels">{{formatZipCode($data['contactZipCode'])}}</span>.
        </p>
        <br>
        <h3 style="text-align: center">
            Serviços/produtos contratados
        </h3>
        <p>
            3. Os produtos/serviços contratados e suas especificidades são:
        </p>
        <br>
        <table style="width: 100%">
            <tr>
                <td class="table-list-header center" style="width: 5%;background-color:{{$data['accountComplementaryColor']}}">
                    QTDE
                </td>
                <td   class="table-list-header center" style="width: 55%;background-color:{{$data['accountComplementaryColor']}}">
                    NOME
                </td>
                <td   class="table-list-header center" style="width: 10%;background-color:{{$data['accountComplementaryColor']}}">
                    IMPOSTO
                </td>
                <td   class="table-list-header center" style="width: 15%;background-color:{{$data['accountComplementaryColor']}}">
                    UNITÁRIO
                </td>
                <td   class="table-list-header center" style="width: 15%;background-color:{{$data['accountComplementaryColor']}}">
                    TOTAL
                </td>
            </tr>

            @foreach ($data['productProposals'] as $productProposal)
            <tr>
                <td class="table-list center" style="font-color:{{$data['accountComplementaryColor']}}">
                    {{$productProposal->amount}}
                </td>
                <td class="table-list left" style="font-color:{{$data['accountComplementaryColor']}}">
                    {{$productProposal->product->name}}
                </td>
                <td class="table-list right" style="font-color:{{$data['accountComplementaryColor']}}">
                    {{formatCurrencyReal($productProposal->subtotalTax_rate)}}
                </td>
                <td class="table-list right" style="font-color:{{$data['accountComplementaryColor']}}">
                    {{formatCurrencyReal($productProposal->product->price)}}
                </td>
                <td class="table-list right" style="font-color:{{$data['accountComplementaryColor']}}">
                    {{formatCurrencyReal($productProposal->subtotalPrice)}}
                </td>
            </tr>
            <tr>
                <td class="description left" colspan="5">
                    {!!html_entity_decode($productProposal->product->description)!!}
                </td>
            </tr>
            @endforeach

<tr>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountComplementaryColor']}}" colspan="3">
                    desconto: 
                </td>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountComplementaryColor']}}" colspan="2">
                    - {{formatCurrencyReal($data['invoiceDiscount'])}}
                </td>
            </tr>

            @if($data['invoiceTotalTransactions'])
            <tr>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountComplementaryColor']}}" colspan="3">
                    pagamentos: 
                </td>
                <td   class="table-list-header right" style="font-size: 14px;background-color:{{$data['accountComplementaryColor']}}" colspan="2">
                    - {{formatCurrencyReal($data['invoiceTotalTransactions'])}}
                </td>
            </tr>
            @endif

            <tr>
                <td   class="table-list-header right"  style="font-size: 14px;background-color:{{$data['accountComplementaryColor']}}" colspan="3">
                    TOTAL: 
                </td>
                <td   class="table-list-header right"   style="font-size: 14px;background-color:{{$data['accountComplementaryColor']}}" colspan="2">
                    {{formatCurrencyReal($data['invoiceTotalPrice'] - $data['invoiceTotalTransactions'])}}
                </td>
            </tr>
            @if($data['invoiceStatus'] == 'rascunho' OR $data['invoiceStatus'] == 'orçamento')
            <tr>
                <td   class="table-list-header right" style="background-color:{{$data['accountComplementaryColor']}}" colspan="3">
                    PARCELAMENTO: 
                </td>
                <td   class="table-list-header right" style="background-color:{{$data['accountComplementaryColor']}}" colspan="2">
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
        <br>
        <br>
        <h3 style="text-align: center">
            Condições gerais
        </h3>
        <p style="text-align: left;margin-top: 0px;">
            {!!html_entity_decode($data['contractText'])!!}
        </p>
        <br>
        <br>
        <br>
        <p style="text-align: center">
            Assinam esse contrato no dia {{date('d/m/Y', strtotime($data['contractDateStart']))}}
        </p>
        <br>
        <br>
        <div style="text-align: center;width: 100%">
            <div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
                <p style="text-align: center">
                    <br>
                    ______________________________________
                    <br>
                    <span class="labels">{{$data['userName']}}</span>
                    <br>
                    <span class="labels">{{$data['accountName']}}</span>
                    <br>
                    contratada
                </p>
            </div>
            <div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
                <p style="text-align: center">
                    ______________________________________
                    <br>
                    <span class="labels">{{$data['contactName']}}</span>
                    <br>
                    <span class="labels">{{$data['companyName']}}</span>
                    <br>
                    contratante
                </p>
            </div>
        </div>
        <br>
        <br>
        <div style="text-align: center;width: 100%">
            <div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
                <p style="text-align: center">
                    ______________________________________
                    <br>
                    <span class="labels">{{$data['contractWitness1']}}</span>
                    <br>
                    testemunha 1
                </p>
            </div>
            <div style="text-align: center;display: inline-block;padding-left: 2%;width: 45%">
                <p style="text-align: center">
                    ______________________________________
                    <br>
                    <span class="labels">{{$data['contractWitness2']}}</span>
                    <br>
                    testemunha 2
                </p>
            </div>
        </div>
        <br>
    </body>
</html>