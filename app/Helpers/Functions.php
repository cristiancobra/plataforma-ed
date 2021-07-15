<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\User;
use App\Models\Question;

if (!function_exists('createButtonAdd')) {

// cria um botao com simbolo de + para adicionar model  a partir da rota
    function createButtonAdd($route, $parameter = null, $value = null) {
        echo "<button class='button-round'>";

        if ($parameter) {
            echo "<a href=" . route($route, [$parameter => $value]) . ">";
        } else {
            echo "<a href=" . route($route) . ">";
        }

        echo "<i class='fa fa-plus' style='color:white'></i>";
        echo "</a>";
        echo "</button>";
    }

}
if (!function_exists('createButtonBack')) {

// cria um botao com simbolo de <- para retornar para página anterior
    function createButtonBack() {
        echo "<a class='circular-button secondary' href=" . url()->previous() . ">
                        <i class='fas fa-arrow-left'></i>
                  </a>";
    }

}
if (!function_exists('createButtonList')) {

// cria um botao com simbolo que vai para o index do model
    function createButtonList($model, $parameter = null, $value = null) {
        $route = "$model.index";
        if ($parameter) {
            echo "<a class='circular-button primary' href=" . route($route, [$parameter => $value]) . ">";
        } else {
            echo "<a class = 'circular-button primary' href = " . route($route) . ">";
        }
        echo "<i class = 'fas fa-list'></i>
                     </a>";
    }

}
if (!function_exists('createButtonShow')) {

// cria um botao com simbolo de OLHO para adicionar visualizar um model
    function createButtonShow($model, $parameter) {
        $link = "$parameter.show";
        echo "<button class = 'button-round'>";
        echo "<a href = " . route($link, [$parameter => $model->id]) . ">";
        echo "<i class = 'fa fa-eye' style = 'color:white'></i>";
        echo "</a>";
        echo "</button>";
    }

}
// cria um botao que vai para a tela de edição do model
if (!function_exists('createButtonEdit')) {
    
    function createButtonEdit($model, $parameter = null, $value = null) {
        $route = "$model.edit";
        if ($parameter) {
            echo "<a class='circular-button secondary' href=" . route($route, [$parameter => $value]) . ">";
        } else {
            echo "<a class = 'circular-button secondary' href = " . route($route) . ">";
        }
        echo "<i class = 'fas fa-edit'></i>
                     </a>";
    }

}

if (!function_exists('createButtonExternalLink')) {

// cria um botao com simbolo de FOGUETE que aponta para links externos
    function createButtonExternalLink($link) {
        echo "<button class = 'button-round'>";
        echo "<a href = '//$link' target = '_blank'>";
        echo "<i class = 'fa fa-rocket' style = 'color:white'></i>";
        echo "</a>";
        echo "</button>";
    }

}
if (!function_exists('createButtonTrash')) {

// gera um botão para o método que envia ou recupera um objeto da lixeira, de acordo com o estado atual
    function createButtonTrash($model, $parameter) {
        if ($model->trash == 1) {
            $link = "$parameter.restore";
            $styleName = 'restore';
            $iconName = 'fa fa-recycle';
        } else {
            $link = "$parameter.trash";
            $styleName = 'delete';
            $iconName = 'fa fa-trash';
        };
        echo "<form style='text-decoration: none;color: black;display: inline-block' action='" . route($link, [$parameter => $model]) . "' method='post'>";
        echo "<input type='hidden' name='_method' value='PUT'>";
        echo "<input type='hidden' name='_token' value='" . csrf_token() . "' />";
        echo "<button id='' class='circular-button $styleName' style='border:none;padding-left:4px;paddint-top:-5px' type='submit'>";
        echo "<i class='$iconName'></i>";
        echo "</button>";
        echo "</form>";
    }

}
if (!function_exists('createFilterSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
    function createFilterSelect($name, $class, array $options, $allLabel = null) {
        echo "<select class = '$class' name = '$name' style = 'width:160px'>";
        if ($allLabel) {
            echo "<option class = 'select' value = ''>
            $allLabel
            </option>";
        }
        foreach ($options as $option) {
            if (old($name) == $option) {
                echo "<option value = '$option' selected = 'selected'>$option</option><br>";
            } else {
                echo "<option value = '$option'>$option</option><br>";
            }
        }
        echo "</select>";
    }

}
if (!function_exists('createFilterSelectModels')) {

// cria as opções de um select recebendo NOME, CLASSE e um MODEL, que exibirá NAME e salvará ID e uma label para todos
    function createFilterSelectModels($name, $class, $models, $allLabel = null) {
        echo "<select class = '$class' name = '$name' style = 'width:160px'>";
        if ($allLabel) {
            echo "<option class = 'select' value = ''>
            $allLabel
            </option>";
        }
        foreach ($models as $model) {
            echo "<option value = \"$model->id\">$model->name</option><br>";
        }
        echo "</select>";
    }

}
if (!function_exists('createDoubleSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array com DUAS POSIÇÕES de OPÇÕES
    function createDoubleSelect($name, $class, array $options) {
        echo "<select class = '$class' name = '$name' value='old('$name')>";
        foreach ($options as $key => $value) {
            echo "<option value = \"$key\">$value</option><br>";
        }
        echo "</select>";
    }

}
if (!function_exists('createDoubleSelectIdName')) {

// cria as opções de um select recebendo NOME, CLASSE e array com POSIÇÃO ID E NOME
    function createDoubleSelectIdName($name, $class, $models, $nullLabel = null, $currentValue = null) {
        echo "<select class = '$class' name = '$name'>";
        if ($currentValue) {
            echo "<option value='$currentValue->id'>$currentValue->name</option><br>";
        }
        if ($nullLabel) {
            echo "<option value=''>$nullLabel</option><br>";
        }
        foreach ($models as $model) {
            if (old($name) == $model->id) {
                echo "<option value='$model->id' selected='selected'>$model->name</option><br>";
            } else {
                echo "<option value='$model->id'>$model->name</option><br>";
            }
        }
        echo "</select>";
    }

}
if (!function_exists('createNumericFormField')) {

// cria um campo de formulário do TIPO número com Label. 
    function createNumericFormField($label, $name, $currentValue = null) {
        echo "<label class='labels' for='$name'>$label:</label>";
        echo "<input type='number' id='$name'  name='$name'  value='$currentValue' style='text-align:right; width:100px'>";
        echo "</br>";
    }

}
if (!function_exists('createTextFormField')) {

// cria um campo de formulário do TIPO texto com Label. 
    function createTextFormField($label, $name, $currentValue = null) {
        echo "<label class='labels' for='$name'>$label:</label>";
        echo "<input type='text' id='$name' name='$name'  value='$currentValue' style='text-align:left; width:200px'>";
        echo "</br>";
    }

}
if (!function_exists('createOpportunitySelect')) {

// select exclusivo para selecionar oportunidade
    function createOpportunitySelect($name, $class, $models, $nullLabel = null, $currentValue = null) {
        echo "<select class = '$class' name = '$name'>";
        if ($currentValue) {
            echo "<option value='$currentValue->id'>$currentValue->name</option><br>";
        }
        if ($nullLabel) {
            echo "<option value=''>$nullLabel</option><br>";
        }
        foreach ($models as $model) {
            if (old($name) == $model->id) {
                echo "<option value='$model->id' selected='selected'>" . $model->name . " de " . $model->company->name . "</option><br>";
            } else {
                echo "<option value='$model->id'>" . $model->name . " de " . $model->company->name . "</option><br>";
            }
        }
        echo "</select>";
    }

}
if (!function_exists('createSelectUsers')) {

// cria as um select com os usuários disponíveis com ID e Name
    function createSelectUsers($class, $users) {
        echo "<select name='user_id'>
            <option  class=$class value='" . Auth::user()->id . "'>Eu</option>";
        foreach ($users as $user) {
            if (old('user_id') == $user->id) {
                echo "<option class='$class' value='$user->id' selected='selected'>" . $user->name . "</option><br>";
            } else {
                echo "<option class='$class' value='$user->id'>" . $user->name . "</option><br>";
            }
        }
        echo "</select>";
    }

}
if (!function_exists('editDoubleSelectIdName')) {

// cria as opções de um select recebendo NOME, CLASSE e array com POSIÇÃO ID E NOME
    function editDoubleSelectIdName($name, $class, $models, $currentValue = null, $nullLabel = null) {
        echo "<select class = '$class' name = '$name'>";
        echo "<option value=''>$currentValue</option><br>";
        if ($nullLabel) {
            echo "<option value=''>$nullLabel</option><br>";
        }
        foreach ($models as $model) {
            echo "<option value=\"$model->id\">$model->name</option><br>";
        }
        echo "</select>";
    }

}
if (!function_exists('editDoubleSelect')) {

    /* cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
      e retorna o valor a editar  com DUAS POSIÇÕES */

    function editDoubleSelect($name, $class, array $options, $currentValue, $currentLabel) {
        echo "<select class = '$class' name = '$name'>";
        echo "<option value=\"$currentValue\">$currentLabel</option>";
        foreach ($options as $key => $value) {
            echo "<option value=\"$key\">$value</option><br>";
        }
        echo "</select>";
    }

}
if (!function_exists('createSimpleSelect')) {

// cria as opções de um select recebendo um array com 1 posição
    function createSimpleSelect($name, $class, array $options, $currentValue = null) {
        echo "<select class=$class name=$name>";
        if ($currentValue != null) {
            echo "<option value='$currentValue'>$currentValue</option>";
        }
        foreach ($options as $option) {
            if (old($name) == $option) {
                echo "<option value='$option' selected='selected'>$option</option><br>";
            } else {
                echo "<option value='$option'>$option</option><br>";
            }
        }
        echo "</select>";
    }

}

if (!function_exists('userAccounts')) {

//  retorna o ID das empresas ao qual o usuário pertence
    function userAccounts() {
        $accountsId = Account::whereHas('users', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                })
                ->get('id');

        return $accountsId;
    }

}
if (!function_exists('userContact')) {

//  retorna os dados do relacionamento Contatos a partir do ID de um usuário
    function userContact($id) {
        $userContact = User::where('id', $id)
                ->with('contact')
                ->first();

        return $userContact;
    }

}
// retorna os meses do ano
if (!function_exists('returnAccountType')) {

    function returnAccountType() {
        return $type = array(
            '1' => '',
            '2' => 'Agricultura',
            '3' => 'Biotecnologia',
            '4' => 'Quimica',
            '5' => 'Aeroespacial',
            '6' => 'Computadores e hardware',
            '7' => 'Construção',
            '8' => 'Consultoria',
            '9' => 'Produtos de consumo',
            '10' => 'Esportes',
            '11' => 'Serviços ao consumidor',
            '12' => 'Marketing digital',
            '13' => 'Educação',
            '14' => 'Eletrônica',
            '15' => 'Eletrônica',
            '16' => 'Moda',
            '17' => 'Serviços financeiros',
            '18' => 'Alimentos e bebidas',
            '19' => 'Jogos',
            '20' => 'serviços de saúde',
            '21' => 'Indústria',
            '22' => 'Internet/serviços da web',
            '23' => 'Serviços de TI',
            '24' => 'Jurídico',
            '25' => 'Estilo de vida',
            '26' => 'Marítimo',
            '27' => 'Marketing/publicidade',
            '28' => 'Mídias e entretenimento',
            '29' => 'Mineração',
            '30' => 'Petróleo e gás',
            '31' => 'Política',
            '32' => 'Imóveis',
            '33' => 'Varejo/distribuição',
            '34' => 'Segurança',
            '35' => 'Software',
            '36' => 'Telecomunicações',
            '37' => 'Transportes',
            '38' => 'Turismo',
            '39' => 'Outros',
        );
    }

}
// retorna os meses do ano
if (!function_exists('returnMonths')) {

    function returnMonths() {
        return $months = array(
            '1' => 'Janeiro',
            '2' => 'Fevereiro',
            '3' => 'Março',
            '4' => 'Abril',
            '5' => 'Maio',
            '6' => 'Junho',
            '7' => 'Julho',
            '8' => 'Agosto',
            '9' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro',
        );
    }

}
// retorna o nome do mês a partir do parâmetro recebido
if (!function_exists('returnMonth')) {

    function returnMonth(int $number) {
        switch ($number) {
            case '1':
                $month = 'Janeiro';
                break;
            case '2':
                $month = 'Fevereiro';
                break;
            case '3':
                $month = 'Março';
                break;
            case '4':
                $month = 'Abril';
                break;
            case '5':
                $month = 'Maio';
                break;
            case '6':
                $month = 'Junho';
                break;
            case '7':
                $month = 'Julho';
                break;
            case '8':
                $month = 'Agosto';
                break;
            case '9':
                $month = 'Setembro';
                break;
            case '10':
                $month = 'Outubro';
                break;
            case '11':
                $month = 'Novembro';
                break;
            case '12':
                $month = 'Dezembro';
                break;
        }
        return($month);
    }

}
// retorna os estados do Brasil
if (!function_exists('returnStates')) {

    function returnStates() {
        return $states = array(
            '' => '',
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espirito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MS' => 'Mato Grosso do Sul',
            'MT' => 'Mato Grosso',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        );
    }

}
// retorna o nome COMPLETO DO ESTADO a partir da sigla
if (!function_exists('returnStateName')) {

    function returnStateName($state) {
        switch ($state) {
            case 'AC':
                $state = 'Acre';
                break;
            case 'AL':
                $state = 'Alagoas';
                break;
            case 'AP':
                $state = 'Amapá';
                break;
            case 'AM':
                $state = 'Amazonas';
                break;
            case 'BA':
                $state = 'Bahia';
                break;
            case 'CE':
                $state = 'Ceará';
                break;
            case 'DF':
                $state = 'Distrito Federal';
                break;
            case 'ES':
                $state = 'Espirito Santo';
                break;
            case 'GO':
                $state = 'Goiás';
                break;
            case 'MA':
                $state = 'Maranhão';
                break;
            case 'MS':
                $state = 'Mato Grosso do Sul';
                break;
            case 'MT':
                $state = 'Mato Grosso';
                break;
            case 'MG':
                $state = 'Minas Gerais';
                break;
            case 'PA':
                $state = 'Pará';
                break;
            case 'PB':
                $state = 'Paraíba';
                break;
            case 'PR':
                $state = 'Paraná';
                break;
            case 'PE':
                $state = 'Pernambuco';
                break;
            case 'PI':
                $state = 'Piauí';
                break;
            case 'RJ':
                $state = 'Rio de Janeiro';
                break;
            case 'RN':
                $state = 'Rio Grande do Norte';
                break;
            case 'RS':
                $state = 'Rio Grande do Sul';
                break;
            case 'RO':
                $state = 'Rondônia';
                break;
            case 'RR':
                $state = 'Roraima';
                break;
            case 'SC':
                $state = 'Santa Catarina';
                break;
            case 'SP':
                $state = 'São Paulo';
                break;
            case 'SE':
                $state = 'Sergipe';
                break;
            case 'TO':
                $state = 'Tocantins';
                break;
        }
        return($state);
    }

}
// gera um botão com a formatação para PRIORIDADE da tarefa  a partir de  $model
if (!function_exists('formatPriority')) {

    function formatPriority($model) {
        switch ($model->priority) {
            case 'baixa':
                echo '<div class="col-1 tb tb-low text-center">baixa</div>';
                break;
            case 'média':
                echo '<div class="col-1 tb tb-medium text-center">média</div>';
                break;
            case 'alta':
                echo '<div class="col-1 tb tb-high text-center">alta</div>';
                break;
            case 'emergência':
                echo '<div class="col-1 tb tb-emergency text-center">emergência</div>';
                break;
        }
    }

}
// gera um DIV com a formatação para PRIORIDADE da tarefa  a partir de  $model
if (!function_exists('formatShowPriority')) {

    function formatShowPriority($model) {
        switch ($model->priority) {
            case 'baixa':
                echo '<div class="low">baixa</div>';
                break;
            case 'média':
                echo '<div class="medium">média</div>';
                break;
            case 'alta':
                echo '<div class="high">alta</div>';
                break;
            case 'emergência':
                echo '<div class="emergency">emergência</div>';
                break;
        }
    }

}
// gera um DIV com a formatação para CATEGORIA do produto  a partir de  $model
if (!function_exists('formatShowCategory')) {

    function formatShowCategory($model) {
        switch ($model->category) {
            case 'serviço':
                echo '<div class="low">serviço</div>';
                break;
            case 'produto físico':
                echo '<div class="medium">produto físico</div>';
                break;
            case 'produto digital':
                echo '<div class="high">produto digital</div>';
                break;
        }
    }

}
// gera um CÉLUA DE TABELA com a formatação para PRIORIDADE da tarefa  a partir de  $model
if (!function_exists('formatPriority')) {

    function formatPriority($model) {
        switch ($model->priority) {
            case 'baixa':
                echo '<div class="td-low">baixa</div>';
                break;
            case 'média':
                echo '<div class="td-medium">média</div>';
                break;
            case 'alta':
                echo '<div class="td-high">alta</div>';
                break;
            case 'emergência':
                echo '<div class="td-emergency">emergência</div>';
                break;
        }
    }

}
// retorna métodos de pagamento
if (!function_exists('returnPaymentMethods')) {

    function returnPaymentMethods() {
        return $states = array(
            'transferência bancária',
            'pix',
            'cartão de crédito',
            'dinheiro',
            'boleto',
        );
    }

}
// retorna os  tipos de  rede social
if (!function_exists('returnSocialmediaType')) {

    function returnSocialmediaType() {
        return $states = array(
            'Facebook',
            'Instagram',
            'Pinterest',
            'Twitter',
            'Youtube',
            'Spotify',
            'Linkedin',
            'Ifood',
            'Google Meu Negocio',
        );
    }

}
// gera um botão com a formatação para STATUS / SITUAÇÃO da rede social partir de  $socialmedia
if (!function_exists('formatsocialmediaStatus')) {

    function formatsocialmediaStatus($socialmedia) {
        switch ($socialmedia->status) {
            case 'publicada':
                echo '<td class="td-published">publicada</td>';
                break;
            case 'desativada':
                echo '<td class="td-disabled">desativada</td>';
                break;
            case 'cancelado':
                echo '<td class="td-canceled">cancelada</td>';
                break;
        }
    }

}
// converte data para o formato brasileiro
if (!function_exists('dateBr')) {

    function dateBr($date) {
        return date('d/m/Y', strtotime($date));
    }

}
// converte data para o formato brasileiro
if (!function_exists('phoneBr')) {

    function phoneBr($number) {
        if (strlen($number) == 10) {
            $formattedNumber = substr_replace($number, '(', 0, 0);
            $formattedNumber = substr_replace($formattedNumber, '9', 3, 0);
            $formattedNumber = substr_replace($formattedNumber, ') ', 3, 0);
            $formattedNumber = substr_replace($formattedNumber, '- ', 9, 0);
        } else {
            $formattedNumber = substr_replace($number, '(', 0, 0);
            $formattedNumber = substr_replace($formattedNumber, ') ', 3, 0);
            $formattedNumber = substr_replace($formattedNumber, '- ', 10, 0);
        }
        return $formattedNumber;
    }

}

// gera um botão com a formatação para STAGE / ETAPADA DE PROSPECÇÃO da oportunidade a partir de  $model
if (!function_exists('formatStage')) {

    function formatStage($model) {
        switch ($model) {
            case 'prospecção':
                echo '<td class="td-prospecting">prospecção</td>';
                break;
            case 'apresentação':
                echo '<td class="td-presentation">apresentação</td>';
                break;
            case 'proposta':
                echo '<td class="td-proposal">proposta</td>';
                break;
            case 'contrato':
                echo '<td class="td-contract">contrato</td>';
                break;
            case 'cobrança':
                echo '<td class="td-bill">cobrança</td>';
                break;
            case 'produção':
                echo '<td class="td-production">produção</td>';
                break;
            case 'concluída':
                echo '<td class="td-conclude">concluída</td>';
                break;
        }
    }

}
// gera um botão com a formatação para STATUS / SITUAÇÃO do CONTRATO  a partir de  $model
if (!function_exists('formatContractStatus')) {

    function formatContractStatus($model) {
        switch ($model->status) {
            case 'cancelado':
                echo '<td class="td-canceled">cancelado</td>';
                break;
            case 'rascunho':
                echo '<td class="td-toDo">rascunho</td>';
                break;
            case 'enviado':
                echo '<td class="td-stuck">enviado</td>';
                break;
            case 'assinado':
                echo '<td class="td-done">assinado</td>';
                break;
        }
    }

}
// gera uma coluna de tabela com a formatação para STATUS / SITUAÇÃO da tarefa  a partir de  $model
if (!function_exists('formatStatus')) {

    function formatStatus($model) {
        switch ($model->status) {
            case 'cancelado':
                echo '<div class="col-1 tb tb-canceled text-center">cancelada</div>';
                break;
            case 'fazer':
                echo '<div class="col-1 tb tb-toDo text-center">fazer</div>';
                break;
            case 'fazendo':
                echo '<div class="col-1 tb tb-doing text-center">fazendo</div>';
                break;
            case 'feito':
                echo '<div class="col-1 tb tb-done text-center">feito</div>';
                break;
            case 'aguardar':
                echo '<div class="col-1 tb tb-stuck text-center">aguardar</div>';
                break;
        }
    }

}
// gera uma coluna de tabela com a formatação para STATUS / SITUAÇÃO da tarefa  a partir de  $model
if (!function_exists('formatOpportunityStatus')) {

    function formatOpportunityStatus($model) {
        switch ($model) {
            case 'negociando':
                echo '<td class="td-dealing">negociando</td>';
                break;
            case 'perdemos':
                echo '<td class="td-lost">perdemos</td>';
                break;
            case 'ganhamos':
                echo '<td class="td-won">ganhamos</td>';
                break;
        }
    }

}
// gera uma DIV com a formatação para ESTÁGIO da oportunidade  a partir de  $model
if (!function_exists('formatShowStage')) {

    function formatShowStage($model) {
        switch ($model) {
            case 'prospecção':
                echo '<div class="prospecting">prospecção</div>';
                break;
            case 'apresentação':
                echo '<div class="presentation">apresentação</div>';
                break;
            case 'proposta':
                echo '<div class="proposal">proposta</div>';
                break;
            case 'contrato':
                echo '<div class="contract">contrato</div>';
                break;
            case 'cobrança':
                echo '<div class="bill">cobrança</div>';
                break;
            case 'produção':
                echo '<div class="production">produção</div>';
                break;
            case 'concluída':
                echo '<div class="conclude">concluída</div>';
                break;
        }
    }

}
// gera uma DIV com a formatação para STATUS / SITUAÇÃO da tarefa  a partir de  $model
if (!function_exists('formatShowStatus')) {

    function formatShowStatus($model) {
        switch ($model->status) {
            case 'cancelado':
                echo '<div class="canceled">cancelada</div>';
                break;
            case 'fazer':
                echo '<div class="to-do">fazer</div>';
                break;
            case 'fazendo':
                echo '<div class="doing">fazendo</div>';
                break;
            case 'feito':
                echo '<div class="done">feito</div>';
                break;
            case 'aguardar':
                echo '<div class="stuck">aguardar</div>';
                break;
            case 'disponível':
                echo '<div class="done">disponível</div>';
                break;
            case 'indisponível':
                echo '<div class="canceled">indisponível</div>';
                break;
            case 'concluida':
                echo '<div class="stuck">alterar</div>';
                break;
            case 'negociando':
                echo '<div class="dealing">negociando</div>';
                break;
            case 'ganhamos':
                echo '<div class="won">ganhamos</div>';
                break;
            case 'perdemos':
                echo '<div class="lost">perdemos</div>';
                break;
        }
    }

}
// gera uma DIV com a formatação para TYPE / TIPO  da imagem  a partir de  $model
if (!function_exists('formatShowType')) {

    function formatShowType($model) {
        switch ($model->type) {
            case 'produto':
                echo '<div class="to-do">produto</div>';
                break;
            case 'logo':
                echo '<div class="doing">logo</div>';
                break;
            case 'imagem perfil':
                echo '<div class="imagem perfil">feito</div>';
                break;
        }
    }

}
// gera um botão com a formatação para STATUS / SITUAÇÃO da tarefa  a partir de  $model
if (!function_exists('formatProductStatus')) {

    function formatProductStatus($model) {
        switch ($model->status) {
            case 'indisponível':
                echo '<td class="td-canceled">indisponível</td>';
                break;
            case 'disponível':
                echo '<td class="td-aproved">disponível</td>';
                break;
        }
    }

}
// formata uma div com cor de acordo com o status para as tabelas de index
if (!function_exists('formatTableStatus')) {

    function formatTableStatus($model) {
        switch ($model->status) {
            case 'indisponível':
                echo '<div class="tb tb-canceled col-1 text-center">indisponível</div>';
                break;
            case 'disponível':
                echo '<tb class="tb tb-aproved col-1 text-center">disponível</tb>';
                break;
            case 'concluida':
                echo '<tb class="tb tb-aproved col-1 text-center">ATUALIZAR</tb>';
                break;
        }
    }

}
// gera um botão com a formatação para STATUS / SITUAÇÃO para ativado ou desativado
if (!function_exists('formatStatusActive')) {

    function formatStatusActive($model) {
        switch ($model->status) {
            case 'desativado':
                echo '<td class="td-canceled">desativado</td>';
                break;
            case 'ativo':
                echo '<td class="td-done">atvivo</td>';
                break;
        }
    }

}
// gera uma coluna TD com a formatação para STATUS / SITUAÇÃO da Fatura  a partir de  $model
if (!function_exists('formatInvoiceStatus')) {

    function formatInvoiceStatus($model) {
        switch ($model->status) {
            case 'rascunho':
                echo '<div class="tb tb-draft col-1">rascunho</div>';
                break;
            case 'orçamento':
                echo '<div class="tb tb-pending col-1">orçamento</div>';
                break;
            case 'cancelada':
                echo '<div class="tb tb-canceled col-1">cancelada</div>';
                break;
            case 'aprovada':
                echo '<div class="tb tb-aproved col-1">aprovada</div>';
                break;
            case 'paga':
                echo '<div class="tb tb-paid col-1">paga</div>';
                break;
            case 'parcial':
                echo '<div class="tb tb-paid col-1">parcial</div>';
                break;
            case 'atrasada':
                echo '<div class="tb tb-late col-1">atrasada</div>';
                break;
        }
    }

}
// gera uma coluna TD  com a formatação para STATUS / SITUAÇÃO da Conta Bancaria  a partir de  $model
if (!function_exists('formatBankAccountStatus')) {

    function formatBankAccountStatus($model) {
        switch ($model->status) {
            case 'desativada':
                echo '<td class="td-canceled">desativada</td>';
                break;
            case 'ativa':
                echo '<td class="td-aproved">ativa</td>';
                break;
            case 'recebendo':
                echo '<td class="td-paid">recebendo</td>';
                break;
        }
    }

}
// retorna STATUS ativo ou desativado
if (!function_exists('returnStatusActive')) {

    function returnStatusActive() {
        return $status = array(
            'ativo',
            'desativado',
        );
    }

}
// retorna o TIPO de um model
if (!function_exists('returnType')) {

    function returnType($name, $class, $model) {
        switch ($model) {
            case 'invoice':
                $all = 'todos os tipos';
                $types = array('receita', 'despesa');
                break;
            case 'product':
                $all = 'todos os tipos';
                $types = array('receita', 'despesa');
                break;
            case 'transaction':
                $all = 'todos os tipos';
                $types = array('crédito', 'débito', 'transferência');
                break;
        }
        echo "<select class = '$class' name = '$name'>";
        echo "<option  class='select' value=''>
			$all
		</option>";
        foreach ($types as $type) {
            echo "<option value=\"$type\">$type</option><br>";
        }
        echo "</select>";
    }

}
// retorna os nomes e códigos dos BANCOS BRASILEIROS
if (!function_exists('returnBanks')) {

    function returnBanks() {
        return $banks = array(
            '' => '',
            '332' => 'Acesso Soluções de Pagamento S.A.',
            '117' => 'Advanced Cc Ltda',
            '272' => 'AGK Corretora de Câmbio S.A.',
            '349' => 'AL5 S.A. CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
            '172' => 'Albatross Ccv S.A.',
            '313' => 'AMAZÔNIA CORRETORA DE CÂMBIO LTDA.',
            '188' => 'Ativa S.A Investimentos',
            '280' => 'Avista S.A.',
            '80' => 'B&T Cc Ltda',
            '654' => 'Banco A.J. Renner S.A.',
            '246' => 'Banco Abc Brasil S.A.',
            '121' => 'Banco Agibank S.A.',
            '25' => 'Banco Alfa S.A.',
            '641' => 'Banco Alvorada S.A.',
            '65' => 'Banco Andbank S.A.',
            '96' => 'Banco B3 S.A.',
            '24' => 'Banco Bandepe S.A.',
            '21' => 'Banco Banestes S.A.',
            '330' => 'Banco Bari de Investimentos e Financiamentos S.A.',
            '250' => 'Banco Bcv',
            '318' => 'Banco BMG S.A.',
            '752' => 'Banco BNP Paribas Brasil S.A.',
            '107' => 'Banco Bocom BBM S.A.',
            '63' => 'Banco Bradescard',
            '36' => 'Banco Bradesco BBI S.A.',
            '122' => 'Banco Bradesco BERJ S.A.',
            '204' => 'Banco Bradesco Cartoes S.A.',
            '394' => 'Banco Bradesco Financiamentos S.A.',
            '218' => 'Banco Bs2 S.A.',
            '208' => 'Banco BTG Pactual S.A.',
            '626' => 'BANCO C6 CONSIGNADO S.A.',
            '336' => 'Banco C6 S.A – C6 Bank',
            '473' => 'Banco Caixa Geral Brasil S.A.',
            '412' => 'Banco Capital S.A.',
            '40' => 'Banco Cargill S.A.',
            '266' => 'Banco Cedula S.A.',
            '739' => 'Banco Cetelem S.A.',
            '233' => 'Banco Cifra S.A.',
            '745' => 'Banco Citibank S.A.',
            '241' => 'Banco Classico S.A.',
            '95' => 'Banco Confidence De Câmbio S.A.',
            '748' => 'Banco Cooperativa Sicredi S.A.',
            '222' => 'Banco Crédit Agricole Br S.A.',
            '505' => 'Banco Credit Suisse (Brl) S.A.',
            '69' => 'Banco Crefisa S.A.',
            '368' => 'Banco CSF S.A.',
            '3' => 'Banco Da Amazônia S.A.',
            '83' => 'Banco Da China Brasil S.A.',
            '707' => 'Banco Daycoval S.A.',
            '654' => 'BANCO DIGIMAIS S.A.',
            '335' => 'Banco Digio S.A.',
            '1' => 'Banco Do Brasil S.A (BB)',
            '47' => 'Banco do Estado de Sergipe S.A.',
            '37' => 'Banco Do Estado Do Pará S.A.',
            '4' => 'Banco Do Nordeste Do Brasil S.A.',
            '196' => 'Banco Fair Cc S.A.',
            '265' => 'Banco Fator S.A.',
            '224' => 'Banco Fibra S.A.',
            '626' => 'Banco Ficsa S.A.',
            '94' => 'Banco Finaxis',
            '390' => 'BANCO GM S.A.',
            '612' => 'Banco Guanabara S.A.',
            '12' => 'Banco Inbursa',
            '604' => 'Banco Industrial Do Brasil S.A.',
            '653' => 'Banco Indusval S.A.',
            '77' => 'Banco Inter S.A.',
            '630' => 'Banco Intercap S.A.',
            '249' => 'Banco Investcred Unibanco S.A.',
            '184' => 'Banco Itaú BBA S.A.',
            '29' => 'Banco Itaú Consignado S.A.',
            '479' => 'Banco ItauBank S.A.',
            '74' => 'Banco J. Safra S.A.',
            '376' => 'Banco J.P. Morgan S.A.',
            '217' => 'Banco John Deere S.A.',
            '76' => 'Banco KDB Brasil S.A.',
            '757' => 'Banco Keb Hana Do Brasil S.A.',
            '300' => 'Banco La Nacion Argentina',
            '600' => 'Banco Luso Brasileiro S.A.',
            '243' => 'Banco Máxima S.A.',
            '389' => 'Banco Mercantil Do Brasil S.A.',
            '389' => 'Banco Mercantil Do Brasil S.A.',
            '381' => 'BANCO MERCEDES-BENZ DO BRASIL S.A.',
            '370' => 'Banco Mizuho S.A.',
            '746' => 'Banco Modal S.A.',
            '66' => 'Banco Morgan Stanley S.A.',
            '456' => 'Banco MUFG Brasil S.A.',
            '169' => 'Banco Olé Bonsucesso Consignado S.A.',
            '111' => 'Banco Oliveira Trust Dtvm S.A.',
            '79' => 'Banco Original Do Agronegócio S.A.',
            '212' => 'Banco Original S.A.',
            '712' => 'Banco Ourinvest S.A.',
            '623' => 'Banco Pan S.A.',
            '611' => 'Banco Paulista',
            '643' => 'Banco Pine S.A.',
            '747' => 'Banco Rabobank Internacional Do Brasil S.A.',
            '88' => 'BANCO RANDON S.A.',
            '633' => 'Banco Rendimento S.A.',
            '494' => 'Banco Rep Oriental Uruguay',
            '741' => 'Banco Ribeirão Preto S.A.',
            '120' => 'Banco Rodobens S.A.',
            '422' => 'Banco Safra S.A.',
            '33' => 'Banco Santander Brasil S.A.',
            '81' => 'Banco Seguro S.A.',
            '743' => 'Banco Semear S.A.',
            '754' => 'Banco Sistema S.A.',
            '630' => 'Banco Smartbank S.A.',
            '366' => 'Banco Societe Generale Brasil',
            '637' => 'Banco Sofisa S.A (Sofisa Direto)',
            '464' => 'Banco Sumitomo Mitsui Brasil S.A.',
            '82' => 'Banco Topázio S.A.',
            '387' => 'Banco Toyota do Brasil S.A.',
            '634' => 'Banco Triangulo S.A (Banco Triângulo)',
            '18' => 'Banco Tricury S.A.',
            '393' => 'Banco Volkswagen S.A.',
            '655' => 'Banco Votorantim S.A.',
            '610' => 'Banco VR S.A.',
            '119' => 'Banco Western Union do Brasil S.A.',
            '124' => 'Banco Woori Bank Do Brasil S.A.',
            '348' => 'Banco XP S/A',
            '756' => 'Bancoob – Banco Cooperativo Do Brasil S.A.',
            '755' => 'Bank of America Merrill Lynch Banco Múltiplo S.A.',
            '41' => 'Banrisul – Banco Do Estado Do Rio Grande Do Sul S.A.',
            '268' => 'Barigui Companhia Hipotecária',
            '378' => 'BBC LEASING S.A. – Arrendamento Mercantil',
            '81' => 'Bbn Banco Brasileiro De Negocios S.A.',
            '75' => 'Bco Abn Amro S.A.',
            '213' => 'Bco Arbi S.A.',
            '144' => 'Bexs Banco De Cambio S.A.',
            '253' => 'Bexs Cc S.A.',
            '134' => 'BGC Liquidez Dtvm Ltda',
            '7' => 'BNDES (Banco Nacional Do Desenvolvimento Social)',
            '17' => 'Bny Mellon Banco S.A.',
            '755' => 'Bofa Merrill Lynch Bm S.A.',
            '383' => 'BOLETOBANCÁRIO.COM TECNOLOGIA DE PAGAMENTOS LTDA.',
            '408' => 'BÔNUSCRED SOCIEDADE DE CRÉDITO DIRETO S.A.',
            '301' => 'BPP Instituição De Pagamentos S.A.',
            '126' => 'BR Partners Banco de Investimento S.A.',
            '237' => 'Bradesco S.A.',
            '125' => 'Brasil Plural S.A Banco',
            '70' => 'BRB – Banco De Brasília S.A.',
            '92' => 'BRK S.A.',
            '173' => 'BRL Trust Dtvm Sa',
            '142' => 'Broker Brasil Cc Ltda',
            '292' => 'BS2 Distribuidora De Títulos E Investimentos',
            '11' => 'C.Suisse Hedging-Griffo Cv S.A (Credit Suisse)',
            '104' => 'Caixa Econômica Federal (CEF)',
            '309' => 'CAMBIONET CORRETORA DE CÂMBIO LTDA.',
            '288' => 'Carol Dtvm Ltda',
            '324' => 'CARTOS SOCIEDADE DE CRÉDITO DIRETO S.A.',
            '130' => 'Caruana Scfi',
            '159' => 'Casa do Crédito S.A.',
            '97' => 'Ccc Noroeste Brasileiro Ltda',
            '16' => 'Ccm Desp Trâns Sc E Rs',
            '279' => 'Ccr De Primavera Do Leste',
            '273' => 'Ccr De São Miguel Do Oeste',
            '89' => 'Ccr Reg Mogiana',
            '114' => 'Central Cooperativa De Crédito no Estado do Espírito Santo',
            '91' => 'Central De Cooperativas De Economia E Crédito Mútuo Do Estado Do Rio Grande Do S',
            '362' => 'CIELO S.A.',
            '477' => 'Citibank N.A.',
            '180' => 'Cm Capital Markets Cctvm Ltda',
            '127' => 'Codepe Cvc S.A.',
            '163' => 'Commerzbank Brasil S.A Banco Múltiplo',
            '60' => 'Confidence Cc S.A.',
            '85' => 'Cooperativa Central de Créditos – Ailos',
            '16' => 'COOPERATIVA DE CRÉDITO MÚTUO DOS DESPACHANTES DE TRÂNSITO DE SANTA CATARINA E RI',
            '281' => 'Cooperativa de Crédito Rural Coopavel',
            '322' => 'Cooperativa de Crédito Rural de Abelardo Luz – Sulcredi/Crediluz',
            '286' => 'Cooperativa de Crédito Rural de De Ouro',
            '391' => 'COOPERATIVA DE CRÉDITO RURAL DE IBIAM – SULCREDI/IBIAM',
            '350' => 'Cooperativa De Crédito Rural De Pequenos Agricultores E Da Reforma Agrária Do Ce',
            '379' => 'COOPERFORTE – Cooperativa De Economia E Crédito Mútuo Dos Funcionários De Instit',
            '403' => 'CORA SOCIEDADE DE CRÉDITO DIRETO S.A.',
            '98' => 'Credialiança Ccr',
            '10' => 'CREDICOAMO CRÉDITO RURAL COOPERATIVA',
            '89' => 'CREDISAN COOPERATIVA DE CRÉDITO',
            '97' => 'Credisis – Central de Cooperativas de Crédito Ltda.',
            '342' => 'Creditas Sociedade de Crédito Direto S.A.',
            '321' => 'CREFAZ SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E A EMPRESA DE PEQUENO PORTE LT',
            '133' => 'Cresol Confederação',
            '182' => 'Dacasa Financeira S/A',
            '289' => 'DECYSEO CORRETORA DE CAMBIO LTDA.',
            '487' => 'Deutsche Bank S.A (Banco Alemão)',
            '140' => 'Easynvest – Título Cv S.A.',
            '149' => 'Facta S.A. Cfi',
            '343' => 'FFA SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE LTDA.',
            '382' => 'FIDÚCIA SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE L',
            '331' => 'Fram Capital Distribuidora de Títulos e Valores Mobiliários S.A.',
            '285' => 'Frente Cc Ltda',
            '278' => 'Genial Investimentos Cvm S.A.',
            '364' => 'GERENCIANET S.A.',
            '138' => 'Get Money Cc Ltda',
            '384' => 'GLOBAL FINANÇAS SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO',
            '64' => 'Goldman Sachs Do Brasil Bm S.A.',
            '177' => 'Guide Investimentos S.A. Corretora de Valores',
            '146' => 'Guitta Cc Ltda',
            '78' => 'Haitong Bi Do Brasil S.A.',
            '62' => 'Hipercard Banco Múltiplo S.A.',
            '189' => 'Hs Financeira',
            '269' => 'Hsbc Banco De Investimento',
            '396' => 'HUB PAGAMENTOS S.A.',
            '271' => 'Ib Cctvm Ltda',
            '157' => 'Icap Do Brasil Ctvm Ltda',
            '132' => 'ICBC do Brasil Bm S.A.',
            '492' => 'Ing Bank N.V.',
            '139' => 'Intesa Sanpaolo Brasil S.A.',
            '652' => 'Itaú Unibanco Holding Bm S.A.',
            '341' => 'Itaú Unibanco S.A.',
            '488' => 'Jpmorgan Chase Bank',
            '399' => 'Kirton Bank S.A. – Banco Múltiplo',
            '495' => 'La Provincia Buenos Aires Banco',
            '293' => 'Lastro Rdv Dtvm Ltda',
            '105' => 'Lecca Cfi S.A.',
            '145' => 'Levycam Ccv Ltda',
            '397' => 'LISTO SOCIEDADE DE CRÉDITO DIRETO S.A.',
            '113' => 'Magliano S.A.',
            '323' => 'Mercado Pago – Conta Do Mercado Livre',
            '274' => 'MONEY PLUS SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E A EMPRESA DE PEQUENO PORT',
            '259' => 'MONEYCORP BANCO DE CÂMBIO S.A.',
            '128' => 'Ms Bank S.A Banco De Câmbio',
            '377' => 'MS SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE LTDA',
            '137' => 'Multimoney Cc Ltda',
            '14' => 'Natixis Brasil S.A.',
            '354' => 'NECTON INVESTIMENTOS S.A. CORRETORA DE VALORES MOBILIÁRIOS E COMMODITIES',
            '655' => 'Neon Pagamentos S.A (Memso Código Do Banco Votorantim)',
            '237' => 'Next Bank (Mesmo Código Do Bradesco)',
            '191' => 'Nova Futura Ctvm Ltda',
            '753' => 'Novo Banco Continental S.A Bm',
            '260' => 'Nu Pagamentos S.A (Nubank)',
            '319' => 'OM DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
            '613' => 'Omni Banco S.A.',
            '325' => 'Órama Distribuidora de Títulos e Valores Mobiliários S.A.',
            '355' => 'ÓTIMO SOCIEDADE DE CRÉDITO DIRETO S.A.',
            '290' => 'PagSeguro Internet S.A.',
            '254' => 'Paraná Banco S.A.',
            '326' => 'PARATI – CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A.',
            '194' => 'Parmetal Dtvm Ltda',
            '174' => 'PEFISA S.A. – CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
            '174' => 'Pernambucanas Financ S.A.',
            '315' => 'PI Distribuidora de Títulos e Valores Mobiliários S.A.',
            '380' => 'PICPAY SERVICOS S.A.',
            '100' => 'Planner Corretora De Valores S.A.',
            '93' => 'PóloCred Scmepp Ltda',
            '108' => 'Portocred S.A.',
            '306' => 'PORTOPAR DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA.',
            '329' => 'QI Sociedade de Crédito Direto S.A.',
            '283' => 'RB Capital Investimentos Dtvm Ltda',
            '374' => 'REALIZE CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A.',
            '101' => 'Renascença Dtvm Ltda',
            '270' => 'Sagitur Cc Ltda',
            '751' => 'Scotiabank Brasil',
            '276' => 'Senff S.A.',
            '545' => 'Senso Ccvm S.A.',
            '190' => 'Servicoop',
            '363' => 'SOCOPA SOCIEDADE CORRETORA PAULISTA S.A.',
            '183' => 'Socred S.A.',
            '365' => 'SOLIDUS S.A. CORRETORA DE CAMBIO E VALORES MOBILIARIOS',
            '299' => 'SOROCRED   CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A.',
            '118' => 'Standard Chartered Bi S.A.',
            '14' => 'STATE STREET BRASIL S.A. – BANCO COMERCIAL',
            '197' => 'Stone Pagamentos S.A.',
            '404' => 'SUMUP SOCIEDADE DE CRÉDITO DIRETO S.A.',
            '340' => 'Super Pagamentos S/A (Superdital)',
            '307' => 'Terra Investimentos Distribuidora de Títulos e Valores Mobiliários Ltda.',
            '352' => 'TORO CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
            '95' => 'Travelex Banco de Câmbio S.A.',
            '143' => 'Treviso Cc S.A.',
            '360' => 'TRINUS Capital Distribuidora De Títulos E Valores Mobiliários S.A.',
            '131' => 'Tullett Prebon Brasil Cvc Ltda',
            '129' => 'UBS Brasil Bi S.A.',
            '15' => 'UBS Brasil Cctvm S.A.',
            '91' => 'Unicred Central Rs',
            '136' => 'Unicred Cooperativa LTDA',
            '99' => 'Uniprime Central Ccc Ltda',
            '84' => 'Uniprime Norte Do Paraná',
            '84' => 'UNIPRIME NORTE DO PARANÁ – COOPERATIVA DE CRÉDITO LTDA',
            '373' => 'UP.P SOCIEDADE DE EMPRÉSTIMO ENTRE PESSOAS S.A.',
            '298' => 'Vip’s Cc Ltda',
            '296' => 'VISION S.A. CORRETORA DE CAMBIO',
            '367' => 'VITREO DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A.',
            '310' => 'VORTX Dtvm Ltda',
            '371' => 'WARREN CORRETORA DE VALORES MOBILIÁRIOS E CÂMBIO LTDA.',
            '102' => 'XP Investimentos S.A.',
            '359' => 'ZEMA CRÉDITO, FINANCIAMENTO E INVESTIMENTO S/A',
        );
    }

}
// retorna o status da CONTA BANCÁRIA
if (!function_exists('returnBankAccountStatus')) {

    function returnBankAccountStatus() {
        return $status = array(
            'ativa',
            'desativada',
            'recebendo',
        );
    }

}
// retorna o STATUS / SITUAÇÃO do contrato 
if (!function_exists('returnContractStatus')) {

    function returnContractStatus() {
        return $status = array(
            'rascunho',
            'enviado',
            'assinado',
            'cancelado',
        );
    }

}
// retorna o STATUS / SITUAÇÃO da fatura 
if (!function_exists('returnInvoiceStatus')) {

    function returnInvoiceStatus() {
        return $status = array(
            'rascunho',
            'orçamento',
            'cancelada',
            'aprovada',
        );
    }

}
// retorna o STATUS / SITUAÇÃO da fatura especificamente para o filtro
if (!function_exists('returnInvoiceStatusToFilter')) {

    function returnInvoiceStatusToFilter() {
        return $status = array(
            'rascunho',
            'orçamento',
            'cancelada',
            'aprovada',
            'parcial',
            'paga',
        );
    }

}

// retorna a CATEGORIA do PRODUTO
if (!function_exists('returnProductCategory')) {

    function returnProductCategory() {
        return $status = array(
            'serviço',
            'produto físico',
            'produto digital',
        );
    }

}
// retorna a SITUAÇÃO do PRODUTO
if (!function_exists('returnProductStatus')) {

    function returnProductStatus() {
        return $status = array(
            'disponível',
            'indisponível',
        );
    }

}
//if (!function_exists('selectOneCollection')) {
//
//// cria as opções de um select recebendo NOME, CLASSE e 1 collection que é duplicada  em value e na label
//	function selectOneCollection($name, $class, $options) {
//		echo "<select class = '$class' name = '$name'  value='old('$name')>";
//		foreach ($options as $option) {
//			echo "<option value=\"$option\">$option</option><br>";
//		}
//		echo "</select>";
//	}
//
//}
if (!function_exists('createSelectIdName')) {

// cria as opções de um select recebendo NOME, CLASSE, COLLECTION e aplica ID em VALUE e NAME no label
    function createSelectIdName($name, $class, $models, $nullLabel = null, $currentValue = null) {
        echo "<select class = '$class' name = '$name'  value='old('$name')>";
        if ($currentValue) {
            echo "<option value='$currentValue->id'>$currentValue->name</option><br>";
        }
        if ($nullLabel) {
            echo "<option value=''>$nullLabel</option><br>";
        }
        foreach ($models as $model) {
            echo "<option value=\"$model->id\">$model->name</option><br>";
        }
        echo "</select>";
    }

}
if (!function_exists('gerarSenha')) {

    function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos) {
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos

        if ($maiusculas) {
// se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
            $senha = str_shuffle($ma);
        }

        if ($minusculas) {
// se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($mi);
        }

        if ($numeros) {
// se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($nu);
        }

        if ($simbolos) {
// se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($si);
        }

// retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
        return substr(str_shuffle($senha), 0, $tamanho);
    }

// retorna número no formato de CEP
    if (!function_exists('formatZipCode')) {

        function formatZipCode($zipCode) {
            $startNumbers = substr($zipCode, 0, 5);
            $endNumbers = substr($zipCode, 5, 8);
            echo $startNumbers . "-" . $endNumbers;
        }

    }
// retorna número no formato de CPF
    if (!function_exists('formatCpf')) {

        function formatCpf($cpf) {
            $part1 = substr($cpf, 0, 3);
            $part2 = substr($cpf, 3, 3);
            $part3 = substr($cpf, 6, 3);
            $part4 = substr($cpf, 9, 2);
            echo $part1 . "." . $part2 . "." . $part3 . "-" . $part4;
        }

    }
// retorna número no formato de CNPJ
    if (!function_exists('formatCnpj')) {

        function formatCnpj($cnpj) {
            $part1 = substr($cnpj, 0, 2);
            $part2 = substr($cnpj, 2, 3);
            $part3 = substr($cnpj, 5, 3);
            $part4 = substr($cnpj, 8, 4);
            $part5 = substr($cnpj, -2);
            echo $part1 . "." . $part2 . "." . $part3 . "/" . $part4 . "-" . $part5;
        }

    }
}
// formata valor inteiro em moeda real com R$
if (!function_exists('formatCurrencyReal')) {

    function formatCurrencyReal($value) {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

}
// formata valor inteiro em moeda real SEM R$
if (!function_exists('formatCurrency')) {

    function formatCurrency($value) {
        return number_format($value, 2, ",", ".");
    }

}
// formata um número com pontos de milhar
if (!function_exists('formatThousands')) {

    function formatThousands($value) {
        return number_format($value, 0, ",", ".");
    }

}
// formata valor inteiro em segundos para formato de decimal (total horas) 
if (!function_exists('formatTotalHour')) {

    function formatTotalHour($value) {
        return number_format($value / 3600, 1, ',', '.');
    }

}
// remove símbolos de números de CPF, CNPJ etc
if (!function_exists('removeSymbols')) {

    function removeSymbols($value) {
        $value = trim($value);
        $value = str_replace(".", "", $value);
        $value = str_replace(",", "", $value);
        $value = str_replace("-", "", $value);
        $value = str_replace("/", "", $value);
        $value = str_replace("=", "", $value);
        return $value;
    }

}
// remove pontos, R$ e troca a vírgula por ponto
if (!function_exists('removeCurrency')) {

    function removeCurrency($value) {
        $value = trim($value);
        $value = str_replace('R', '', $value);
        $value = str_replace('$', '', $value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return $value;
    }

}

if (!function_exists('createSidebarItem')) {

// cria o menu sidebar com itens principais e submenus
    function createSidebarItem($groupName, $groupFaIcon, $aria, $backgroundColor, $oppositeColor, $principalColor, array $itens) {
        echo "
         <div class='dropdown'>
            <button class='dropdown-btn dropdown-toggle' type='button' id='dropdownMenuButtonFinanceiro' data-bs-toggle='dropdown' aria-expanded='false'  style='background-color:$backgroundColor'>
                <i class='$groupFaIcon'></i>
                <span class='d-none d-xl-inline'>$groupName</span>
            </button>
            <ul class='dropdown-menu' style='background-color:$oppositeColor;color:$principalColor' aria-labelledby='$aria'>
                ";

        foreach ($itens as $item) {
            echo "
                  <li class='nav-item'>
                    <a class='dropdown-item link-light' href='" . $item['link'] . "' style='background-color:$oppositeColor'>
                        <i class='" . $item['faIcon'] . " ms-0 me-1'></i>
                        <span class='d-xl-inline'>" . $item['name'] . "</span>
                    </a>
                </li>
                ";
        }
        echo "
            </ul>
        </div>           
";
    }

// Gera Cabeçalho do relatório de social media em reports 

    if (!function_exists('createSocialmediaHeader')) {

        function createSocialmediaHeader($socialmediaReport) {
            $socialmediaName = strtolower($socialmediaReport->socialmedia->socialmedia_name);
            $socialmediaImage = "/images/socialmedia/" . $socialmediaName . ".png";
//            dd(asset($socialmediaImage));

            echo"<div class='row " . $socialmediaName . " '>";
            echo"<div class='col-1'>";
            echo"<img src='" . asset($socialmediaImage) . "' style='width: 75px;height: 75px;text-align: center'>";
            echo"</div>";
            echo"<div class='col-9'>";
            echo"<p style='font-size:20px;font-weight:800'>";
            echo strtoupper($socialmediaReport->socialmedia->socialmedia_name);
            echo"</p>";
            echo"<p style='font-size:14p;margin-top:-15px'>";
            echo $socialmediaReport->socialmedia->name;
            echo"<br>";
            echo $socialmediaReport->socialmedia->URL_name;
            echo"</p></div>";
            echo"<div class='col-2'>";
            echo"<p style='font-size:36px;text-align:center;font-weight:800'>";
            echo formatThousands($socialmediaReport->followers);
            echo"</p>";
            echo"<p style='font-size:20px;text-align:center;margin-top:-20px'>";
            echo"seguidores";
            echo"</p>";
            echo"</div></div><br>";
        }

    }
// Gera Cabeçalho do relatório de concorrentes em reports 

    if (!function_exists('createCompetitorHeader')) {

        function createCompetitorHeader($competitorReport) {
            echo"<div class='row competitor' style='margin-top:40px'>";
            echo"<div class='col-12'>";
            echo"<p style='font-size:24px;font-weight:800'>";
            echo strtoupper($competitorReport->company->name);
            echo"</p>";
            echo"<p style='font-size:16px;font-weight:600;margin-top:-15px'>";
            echo strtoupper($competitorReport->company->business_model);
            echo"</p>";
            echo"</div></div><br>";
        }

    }
// Gera respostas do perguntas de mkt
    if (!function_exists('createSocialmediaQuestions')) {

        function createSocialmediaQuestions($socialmediaReport) {

            foreach ($socialmediaReport->getAttributes() as $key => $value) {
                if (
                        $key == 'id'
                        OR
                        $key == 'account_id'
                        OR
                        $key == 'socialmedia_id'
                        OR
                        $key == 'report_id'
                        OR
                        $key == 'business_model'
                        OR
                        $key == 'type'
                        OR
                        $key == 'status'
                        OR
                        $key == 'created_at'
                        OR
                        $key == 'updated_at'
                ) {
                    
                } else {

                    $question = Question::where('criterion', $key)
                            ->first();

                    if (!$question) {
                        
                    } else {
                        echo "<div class = row>";
                        echo "<div  class='col-11 labels' style='border-bottom: 1px; border-bottom-style: solid;margin-top:15px'>";
                        echo $question->question;
                        echo "</div>";

                        if ($value === 1) {
                            echo "<div class='col-1 btn btn-info' style='padding: 0.5rem 2rem;text-align: center ' >SIM";
                        } else {
                            echo"<div class= 'col-1 btn btn-danger' style='padding: 0.5rem 2rem;text-align: center'>NÃO";
                        }
                        echo "</div></div>";

                        echo"<div class='row'>";
                        echo"<div>";
                        echo"<p style='font-style:italic;text-align: justify'>";
                        if ($value === 1) {
                            echo $question->answer1;
                        } else {
                            echo $question->answer3;
                        }
                        echo"</p>";
                        echo"</div></div>";
                    }
                }
            }
        }

    }
// Gera respostas do perguntas de para COMPETIDORES (sem análise das respostas)
    if (!function_exists('createSocialmediaCompetitorQuestions')) {

        function createSocialmediaCompetitorQuestions($socialmediaReport) {

            foreach ($socialmediaReport->getAttributes() as $key => $value) {
                if (
                        $key == 'id'
                        OR
                        $key == 'account_id'
                        OR
                        $key == 'socialmedia_id'
                        OR
                        $key == 'report_id'
                        OR
                        $key == 'type'
                        OR
                        $key == 'status'
                        OR
                        $key == 'created_at'
                        OR
                        $key == 'updated_at'
                ) {
                    
                } else {

                    $question = Question::where('criterion', $key)
                            ->first();

                    if (!$question) {
                        
                    } else {
                        echo "<div class = row>";
                        echo "<div  class='col-11' style='border-bottom: 1px; border-bottom-style: solid'>";
                        echo $question->question;
                        echo "</div>";

                        if ($value === 1) {
                            echo "<div class='col-1 btn btn-info' style='padding: 0.5rem 2rem;text-align: center ' >SIM";
                        } else {
                            echo"<div class= 'col-1 btn btn-danger' style='padding: 0.5rem 2rem;text-align: center'>NÃO";
                        }
                        echo "</div></div>";
                    }
                }
            }
        }

    }


// Gera respostas das perguntas de competitor
    if (!function_exists('createReportQuestions')) {

        function createReportCompetitor($criterion, $value) {

            echo "<div class= 'row' style='border-bottom-style: solid; border-bottom-width: 1px' >";
            echo"<div class='labels col-3'> $criterion:";
            echo"</div>";
            echo"<div class='col-9'>";
            echo"$value";
            echo"</div>";
            echo"</div>";
        }

    }
}
// Gera respostas das perguntas de competitor
if (!function_exists('createReportAccountQuestions')) {

    function createReportAccountQuestions($accountReport) {
        foreach ($accountReport->getAttributes() as $key => $value) {
            if (
                    $key == 'id'
                    OR
                    $key == 'account_id'
                    OR
                    $key == 'report_id'
                    OR
                    $key == 'created_at'
                    OR
                    $key == 'updated_at'
            ) {
                
            } else {

                $question = Question::where('criterion', $key)
                        ->first();

                if (!$question) {
                    
                } else {
                    echo "<div class = row>";
                    echo "<div  class='col-11 labels' style='border-bottom: 1px; border-bottom-style: solid'>";
                    echo $question->question;
                    echo "</div>";

                    if ($value === 1) {
                        echo "<div class='col-1 btn btn-info' style='padding: 0.5rem 2rem;text-align: center ' >SIM";
                    } else {
                        echo"<div class= 'col-1 btn btn-danger' style='padding: 0.5rem 2rem;text-align: center'>NÃO";
                    }
                    echo "</div></div>";

                    echo"<div class='row'>";
                    echo"<div>";
                    echo"<p style='font-style:italic;text-align: justify'><br><br>";
                    if ($value === 1) {
                        echo $question->answer1;
                    } else {
                        echo $question->answer3;
                    }
                    echo"</p>";
                    echo"</div></div>";
                }
            }
        }
    }

}

// calcular porcentagem de um valor em relação ao valor total
if (!function_exists('percentage')) {

    function percentage($number, $total) {
        return number_format($number / $total * 100, 1);
    }

}

// cria tabela com nome do item, total do item e percentual do item
if (!function_exists('createTablePercentual')) {

    function createTablePercentual($name, array $items) {
        echo "<div class='row mt-3 ms-2'>
    <div class='tb-header-start col-8'>";
        echo $name;
        echo "</div>
    <div class='tb-header col-2'>
            total
    </div>
    <div class='tb-header-end col-2'>
            percentual
    </div>
</div>";

        foreach ($items as $item) {
            echo "<div class='row ms-2'>
    <div class='tb col-8 justify-content-start'>";
            echo $item['name'];
            echo "</div>
    <div class='tb col-2 justify-content-end pe-2'>";
            echo $item['total'];
            echo "</div>
    <div class='tb col-2 justify-content-end pe-2'>";
            echo $item['percentual'];
            echo "%
        </div>
</div>";
        }
    }

}

// cria tuma pergunta com SIM ou NAO para CRIAR a análise da página em socialmedia
if (!function_exists('createPageAnalysis')) {

    function createPageAnalysis($question, $field) {
        echo "<label class='labels' for=''>$question</label>
        <br>
        <input type='radio' name='$field' value='1' checked='checked'><span class='fields'>Sim</span>
        <br>
        <input type='radio' name='$field' value='0'><span class='fields'>Não</span>
        <br><br>";
    }

}

// cria tuma pergunta com SIM ou NAO para EDITAR a análise da página em socialmedia
if (!function_exists('editPageAnalysis')) {

    function editPageAnalysis($question, $field, $currentValue) {
        echo "<label class='labels' for=''>$question</label>
        <br>";
        if ($currentValue == 1) {
            echo "<input type='radio' name='$field' value='1' checked='checked'><span class='fields'>Sim</span>
            <br>
                <input type='radio' name='$field' value='0'><span class='fields'>Não</span>";
        } else {
            echo "<input type='radio' name='$field' value='1'><span class='fields'>Sim</span>
            <br>
        <input type='radio' name='$field' value='0' checked='checked><span class='fields'>Não</span>";
        }
        echo "<br><br>";
    }

}



//         <td   class="table-list-left">
//                POSSUI  PALETA DE CORES:
//            </td>
//            @if ($report->accountReport->pallet  === 1)
//			<td class="btn btn-info" style="padding: 0.5rem 2rem;text-align: center">
//                SIM
//            </td>
//        </tr>
//        <tr>
//            <td colspan="2">
//                <p style="font-style:italic;text-align: justify">
//                    <br>
//                    Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! Talvez você ainda não seja um expert: é sempre possível colher mais dados para melhorar o visual, o estilo, a personalidade, o tom de voz, o gênero, entre uma infinidade de outras características a respeito da sua marca. Com técnicas de SEO e UXdesign é possível realizar uma transformação digital e levar a sua marca para outro patamar.  
//                    <br>
//                    Leve sua marca para outro nível! Contrate uma consultoria especializada em marketing digital 
//                    <br>
//                    <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
//                        AVANÇAR
//                    </a>
//                    <br>
//                    <br>
//                </p>
//            </td>
//        </tr>
//		@else
//        <td class="btn btn-danger" style="padding: 0.5rem 2rem;text-align: center">
//            NÃO
//        </td>
//        <tr>
//            <td colspan="2">
//                <p style="font-style:italic;text-align: justify">
//                    Quando você não possui um kit de UI, a identidade visual fica bagunçada. O objetivo em se ter um kit de UI é criar um estilo que vai além da logomarca. Para criar uma identidade visual homogênea você deve: criar uma paleta de cores, estilos de fontes, estilos de ícones, estilos de fotos, estilos de ilustração, estilos de botões entre outros itens que identificarão a sua marca.
//                    <br>
//                    Contrate a criação de identidade visual 
//                    <br>
//                    <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5516981076049">
//                        AVANÇAR
//                    </a>
//                    <br>
//                    <br>
//                </p>
//            </td>
//        </tr>
//        @endif
//    </table>