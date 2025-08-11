<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationsController extends Controller {

    public function index() {
        $prospeccao = 'prospecção';
        $apresentacao = 'apresentação';
        $proposta = 'proposta';
        $contrato = 'contrato';
        $cobranca = 'cobrança';
        $producao = 'produção';
        $concluída = 'concluída';

        $negociando = 'negociando';
        $perdemos = 'perdemos';
        $ganhamos = 'ganhamos';

        return view('/configurations/configurations', compact(
                        'prospeccao',
                        'apresentacao',
                        'proposta',
                        'contrato',
                        'cobranca',
                        'producao',
                        'concluída',
                        'negociando',
                        'perdemos',
                        'ganhamos',
        ));
    }

}
