@extends('layouts/master')

@section('title','PALETA DE CORES')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('buttons')

@endsection

@section('main')
<div class="row">
    <div class='col-3'>
        <table>
            <tr>
                <td colspan="2">
                    Oportunidades ETAPA
                </td>
            </tr>
                <tr>
                    {{formatStage($prospeccao)}}
                </tr>
                <tr>
                    {{formatStage($apresentacao)}}
                </tr>
                <tr>
                    {{formatStage($proposta)}}
                </tr>
                <tr>
                    {{formatStage($contrato)}}
                </tr>
                <tr>
                    {{formatStage($cobranca)}}
                </tr>
                <tr>
                    {{formatStage($producao)}}
                </tr>
                <tr>
                    {{formatStage($concluída)}}
                </tr>
            </table>
    </div>
    <div class='col-3'>
        <div>
            Oportunidades ETAPA
        </div>
        {{formatShowStage($prospeccao)}}
        {{formatShowStage($apresentacao)}}
        {{formatShowStage($proposta)}}
        {{formatShowStage($contrato)}}
        {{formatShowStage($cobranca)}}
        {{formatShowStage($producao)}}
        {{formatShowStage($concluída)}}
    </div>
    <div class='col-3'>
            <table>
            <tr>
                <td colspan="2">
                    Oportunidades SITUAÇÃO
                </td>
            </tr>
                <tr>
                    {{formatOpportunityStatus($negociando)}}
                </tr>
                <tr>
                    {{formatOpportunityStatus($perdemos)}}
                </tr>
                <tr>
                    {{formatOpportunityStatus($ganhamos)}}
                </tr>
            </table>
    </div>
        <div class='col-3'>
        <div>
            Oportunidades SITUAÇÃO
        </div>
        {{formatShowOpportunityStatus($negociando)}}
        {{formatShowOpportunityStatus($perdemos)}}
        {{formatShowOpportunityStatus($ganhamos)}}
    </div>
</div>
@endsection