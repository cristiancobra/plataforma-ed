{{-- Badge de situação/prioridade/etapa a partir do valor (tarefas, contratos, propostas, faturas...).
     Uso: <x-table.status :value="$task->status" /> ; valores desconhecidos aparecem em cinza. --}}
@props(['value' => null])

@php
    $green = ['#E8F5E9', '#2E7D32'];
    $red = ['#FFEBEE', '#C62828'];
    $gray = ['#ECEFF1', '#546E7A'];
    $amber = ['#FFF8E1', '#B26A00'];
    $blue = ['#E3F2FD', '#1565C0'];
    $orange = ['#FFF3E0', '#E65100'];

    $map = [
        // situação
        'aguardar' => $amber, 'negociando' => $amber, 'orçamento' => $amber, 'enviado' => $amber,
        'fazer' => $blue, 'parcial' => $blue, 'vigente' => $blue,
        'fazendo' => ['#E1F5FE', '#0277BD'],
        'aprovado' => $green, 'aprovada' => $green, 'ativada' => $green, 'ativo' => $green, 'feito' => $green,
        'ganhamos' => $green, 'paga' => $green, 'assinado' => $green, 'publicada' => $green, 'ativa' => $green,
        'atrasada' => $red, 'perdemos' => $red, 'revisão' => $red, 'vencido' => $red, 'desativado' => $red,
        'desativada' => $red,
        'cancelado' => $gray, 'cancelada' => $gray, 'desistimos' => $gray, 'rascunho' => $gray,
        // prioridade
        'baixa' => $blue, 'média' => $amber, 'alta' => $orange, 'emergência' => $red,
    ];
@endphp

<x-table.badge :label="$value" :colors="$map[$value] ?? null" />
