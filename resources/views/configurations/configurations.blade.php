@extends('layouts/master')

@section('title','PALETA DE CORES')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('buttons')

@endsection

@section('main')
<div class="row">
    <div class='col-4'>
        <table>
            <tr>
                <td colspan="2">
                    Oportunidades INDEX
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
    <div class='col-4'>
        <div>
            Oportunidades SHOW
        </div>
        {{formatStage($prospeccao)}}
        {{formatShowStage($apresentacao)}}
        {{formatShowStage($proposta)}}
        {{formatShowStage($contrato)}}
        {{formatShowStage($cobranca)}}
        {{formatShowStage($producao)}}
        {{formatShowStage($concluída)}}
    </div>
    <div class='col-4'>
        <div>
            Oportunidades status
        </div>
        {{formatOpportunityStatus($negociando)}}
        {{formatOpportunityStatus($perdemos)}}
        {{formatOpportunityStatus($ganhamos)}}
    </div>
</div>
@endsection