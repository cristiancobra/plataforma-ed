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
                    <h1 style="float: left;vertical-align: super;color:white">
                        RELATÓRIO DE EXECUÇÃO
                    </h1>
                        <img style='float: right' src='{{$data['accountLogo']}}' height='50px' width='150px'>
        </header>
        <footer style="background-color:{{$data['accountPrincipalColor']}}">
            CNPJ: {{$data['accountCnpj']}}
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
                @if(isset($data['customerName']))
                {{$data['customerName']}}
                <br>
                @endif
                @if(isset($data['companyName']))
                {{$data['companyName']}}
                @endif
                @if(isset($data['companyCnpj']))
                <br>
                CNPJ: {{$data['companyCnpj']}} -- 
                @endif
                @if(isset($data['email']))
                {{$data['email']}}
                @endif
                @if(isset($data['phone']))
                -- {{$data['phone']}}
                @endif
                @if(isset($data['address']))
                <br>
                {{$data['address']}}  -- 
                {{$data['city']}} / 
                {{$data['state']}} -
                {{$data['country']}}
                @endif
            </p>
        </div>
        <br>
        <h4 style="text-align:center;color:{{$data['accountPrincipalColor']}}">
            DESCRIÇÃO DA TAREFA
        </h4>
        <p style="font-weight:bold;color:{{$data['accountPrincipalColor']}}">
            IDENTIFICADOR: <span style='color:black;font-weight: normal'>{{$data['taskIdentifier']}}</span>
            <br>
            NOME: <span style='color:black;font-weight: normal'>{{$data['taskName']}}</span>
            <br>
            INÍCIO: <span style='color:black;font-weight: normal'>{{dateBr($data['taskDateStart'])}}</span>
            <br>
            VENCIMENTO: <span style='color:black;font-weight: normal'>{{dateBr($data['taskDateDue'])}}</span>
            <br>
            <br>
            DESCRITIVO: 
        </p>
        <p style="text-align: left;margin-top: 0px;">
            {!!html_entity_decode($data['taskDescription'])!!}
        </p>
        <br>
        <h4 style="text-align:center;color:{{$data['accountPrincipalColor']}}">
            JORNADAS DE TRABALHO
        </h4>
        <table  class="table-list" style="width: 670px">
            <tr>
                <td class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    ID
                </td>
                <td   class="table-list-header" style="width: 50%;background-color:{{$data['accountPrincipalColor']}}">
                    NOME
                </td>
                <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    DATA 
                </td>
                <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    INÍCIO 
                </td>
                <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    TÉRMINO 
                </td>
                <td   class="table-list-header" style="width: 10%;background-color:{{$data['accountPrincipalColor']}}">
                    DURAÇÃO
                </td>
            </tr>

            @foreach ($data['journeys'] as $journey)
            <tr style="width: 100%; text-align: center;font-size: 13px">
                <td class="table-list-center">
                    {{$journey->id}}
                </td>
                <td class="table-list-left">
                    {{$journey->user->contact->name}}
                </td>
                <td class="table-list-center">
                    {{date('d/m/Y', strtotime($journey->date))}}
                </td>
                <td class="table-list-center">
                    {{date('H:i', strtotime($journey->start_time))}}
                </td>
                <td class="table-list-center">
                    @if($journey->end_time == null)
                    --
                    @else
                    {{date('H:i', strtotime($journey->end_time))}}
                    @endif
                </td>
                <td class="table-list-center" style="color:white;background-color: #874983;padding: 4px">
                    {{gmdate('H:i', $journey->duration)}}
                </td>
            </tr>
            <tr style="font-size: 12px">
                <td class="table-list-left" colspan="6">
                    {!!html_entity_decode($journey->description)!!}
                </td>
            </tr>
            @endforeach

            <tr>
                <td   class="table-list-header-right"  style="font-size: 14px;background-color:{{$data['accountPrincipalColor']}}" colspan="5">
                    TEMPO TOTAL: 
                </td>
                <td   class="table-list-header-right"   style="font-size: 14px;padding-right: 5px;background-color:{{$data['accountPrincipalColor']}}" colspan="1">
                    {{number_format($data['taskTotalDuration'] / 3600, 1, ',','.')}} horas
                </td>
            </tr>
        </table>
        <br>
        <br>
    </body>
</html>