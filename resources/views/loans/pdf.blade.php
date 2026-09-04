<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Empréstimo #{{ $data['loanId'] }}</title>
    <!-- Styles -->
    <style>
        * {
            font-family: Nunito, helvetica, sans-serif;
        }

        .break {
            page-break-after: always;
        }

        .header2 {
            color: white;
            text-align: left;
            font-size: 25px;
            padding-top: 0px;
            padding-left: 25px;
            border-radius: 20px;
            background-color: grey;
            height: 80px;
        }

        .table-list-header {
            color: white;
            font-size: 14px;
            padding: 8px;
            border-radius: 10px;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .table-list {
            color: black;
            font-size: 14px;
            font-weight: 600;
            padding-top: 20px;
            padding-bottom: 10px;
            margin-top: 10px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
            border-style: solid;
            border-bottom-width: 1px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            color: white;
            font-size: 13px;
            font-weight: 700;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            width: 30%;
        }

        .info-value {
            color: black;
            font-size: 13px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            width: 58%;
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

        .item-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .item-title {
            font-size: 16px;
            font-weight: bold;
            color: {{ $data['accountPrincipalColor'] }};
            margin-bottom: 10px;
        }

        .item-detail {
            font-size: 13px;
            margin-bottom: 5px;
        }

        .item-detail strong {
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }

        .section-title {
            color: {{ $data['accountPrincipalColor'] }};
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 2px solid {{ $data['accountPrincipalColor'] }};
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <div style="padding-top: 15px;">
        <h2 style="color:{{ $data['accountPrincipalColor'] }}; text-align: center;">
            EMPRÉSTIMO #{{ $data['loanId'] }}
        </h2>

        <div style="text-align: center; margin-bottom: 20px;">
            <span class="status-badge"
                style="background-color: 
                @if ($data['status'] == 'ATRASADO') #dc3545
                @elseif($data['status'] == 'ATIVO') #0d6efd
                @elseif($data['status'] == 'DEVOLVIDO') #198754
                @elseif($data['status'] == 'PENDENTE') #6c757d
                @else #212529 @endif
            ">
                {{ $data['status'] }}
            </span>
        </div>

        <h4 class="section-title">INFORMAÇÕES DO EMPRÉSTIMO</h4>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                EMPRESTADOR:
            </div>
            <div class="info-value">
                {{ $data['lenderName'] }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                DEVEDOR:
            </div>
            <div class="info-value">
                {{ $data['borrowerName'] }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                TIPO DEVEDOR:
            </div>
            <div class="info-value">
                {{ $data['borrowerType'] }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                DATA EMPRÉSTIMO:
            </div>
            <div class="info-value">
                {{ $data['startDate']->format('d/m/Y') }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                DATA VENCIMENTO:
            </div>
            <div class="info-value">
                {{ $data['dueDate']->format('d/m/Y') }}
                @if ($data['status'] == 'ATRASADO')
                    <span style="color: #dc3545; font-weight: bold;"> - VENCIDO</span>
                @endif
            </div>
        </div>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                DATA DEVOLUÇÃO:
            </div>
            <div class="info-value">
                @if ($data['returnedDate'])
                    {{ $data['returnedDate']->format('d/m/Y') }}
                @else
                    Ainda não devolvido
                @endif
            </div>
        </div>

        <div class="info-row">
            <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                QTDE ITENS:
            </div>
            <div class="info-value">
                {{ $data['totalItems'] }} {{ $data['totalItems'] === 1 ? 'item' : 'itens' }}
            </div>
        </div>

        @if ($data['destination'])
            <div class="info-row">
                <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                    DESTINO:
                </div>
                <div class="info-value">
                    {{ $data['destination'] }}
                </div>
            </div>
        @endif

        @if ($data['notes'])
            <div class="info-row">
                <div class="info-label" style="background-color: {{ $data['accountComplementaryColor'] }}">
                    OBSERVAÇÕES:
                </div>
                <div class="info-value">
                    {{ $data['notes'] }}
                </div>
            </div>
        @endif

        <h4 class="section-title">ITENS EMPRESTADOS</h4>

        @foreach ($data['loanItems'] as $loanItem)
            <div class="item-card">
                <div class="item-title">
                    {{ $loanItem->collection->name }}
                </div>

                <div class="item-detail">
                    <strong>Tipo:</strong> {{ $loanItem->collection->collectionType->name ?? 'N/A' }}
                </div>

                @if ($loanItem->collection->patrimony_number)
                    <div class="item-detail">
                        <strong>Patrimônio:</strong> {{ $loanItem->collection->patrimony_number }}
                    </div>
                @endif

                @if ($loanItem->collection->author)
                    <div class="item-detail">
                        <strong>Autor:</strong> {{ $loanItem->collection->author }}
                    </div>
                @endif

                @if ($loanItem->collection->isbn)
                    <div class="item-detail">
                        <strong>ISBN:</strong> {{ $loanItem->collection->isbn }}
                    </div>
                @endif

                @if ($loanItem->condition_on_loan)
                    <div class="item-detail" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #ddd;">
                        <strong>Condição no empréstimo:</strong><br>
                        <span style="color: #666; font-style: italic;">{{ $loanItem->condition_on_loan }}</span>
                    </div>
                @endif

                @if ($loanItem->condition_on_return)
                    <div class="item-detail" style="margin-top: 8px;">
                        <strong>Condição na devolução:</strong><br>
                        <span style="color: #666; font-style: italic;">{{ $loanItem->condition_on_return }}</span>
                    </div>
                @endif
            </div>
        @endforeach

        <div
            style="margin-top: 40px; padding-top: 20px; border-top: 2px solid {{ $data['accountComplementaryColor'] }};">
            <p style="text-align: center; font-size: 12px; color: #666;">
                Este documento foi gerado em {{ date('d/m/Y H:i') }}
            </p>
        </div>
    </div>
</body>

</html>
