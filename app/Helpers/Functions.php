<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\User;

if (!function_exists('createSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
	function createSelect($name, $class, array $options) {
		echo "<select class = '$class' name = '$name'>";
		foreach ($options as $option) {
			echo "<option value=\"$option\">$option</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('createDoubleSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array com DUAS POSIÇÕES de OPÇÕES
	function createDoubleSelect($name, $class, array $options) {
		echo "<select class = '$class' name = '$name'>";
		foreach ($options as $key => $value) {
			echo "<option value=\"$key\">$value</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('createDoubleSelectIdName')) {

// cria as opções de um select recebendo NOME, CLASSE e array com POSIÇÃO ID E NOME
	function createDoubleSelectIdName($name, $class, $models) {
		echo "<select class = '$class' name = '$name'>";
		foreach ($models as $model) {
			echo "<option value=\"$model->id\">$model->name</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('editSelect')) {

	/* cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
	  e retorna o valor a editar */

	function editSelect($name, $class, array $options, $currentValue) {
		echo "<select class = '$class' name = '$name'>";
		echo "<option value='$currentValue'>$currentValue</option>";
		foreach ($options as $option) {
			echo "<option value=\"$option\">$option</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('editDoubleSelect')) {

	/* cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
	  e retorna o valor a editar  com DUAS POSIÇÕES */

	function editDoubleSelect($name, $class, array $options, $currentValue1, $currentValue2) {
		echo "<select class = '$class' name = '$name'>";
		echo "<option value='$currentValue1'>$currentValue2</option>";
		foreach ($options as $key => $value) {
			echo "<option value=\"$key\">$value</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('createSimpleSelect')) {

// cria as opções de um select recebendo um array com 1 posição
	function createSimpleSelect(array $options) {
		foreach ($options as $option) {
			echo "<option value=\"$option\">$option</option><br>";
		}
	}

}
//if (!function_exists('filterTasks')) {
// filtro das tarefas
//	function filterTasks(array $filters) {
//		if ($filters->name == null && $filters->user_id == null && $filters->contact_id == null && $filters->status == null) {
//				$tasks = Task::where(function ($query) use ($accountsID, $request) {
//							$query->whereIn('account_id', $accountsID);
//							$query->where('status', '!=', 'feito')
//							->where('status', '!=', 'cancelado');
//						})
////						->orderByRaw(DB::raw("FIELD(status, 'fazendo agora', 'pendente')"))
//						->with('opportunity')
//						->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
//						->orderBy('date_due', 'ASC')
//						->paginate(20);
//		}
//	}

if (!function_exists('userAccounts')) {

//  retorna o ID das empresas ao qual o usuário pertence
	function userAccounts() {
		$accountsID = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
				})
				->get('id');

		return $accountsID;
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
		if ($number == 1) {
			$month = "Janeiro";
		}
		if ($number == 2) {
			$month = "Fevereiro";
		}
		if ($number == 3) {
			$month = "Março";
		}
		if ($number == 4) {
			$month = "Abril";
		}
		if ($number == 5) {
			$month = "Maio";
		}
		if ($number == 6) {
			$month = "Junho";
		}
		if ($number == 7) {
			$month = "Julho";
		}
		if ($number == 8) {
			$month = "Agosto";
		}
		if ($number == 9) {
			$month = "Setembro";
		}
		if ($number == 10) {
			$month = "Outubro";
		}
		if ($number == 11) {
			$month = "Novembro";
		}
		if ($number == 12) {
			$month = "Dezembro";
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
// retorna os estágios das oportunidades
if (!function_exists('returnOpportunitieStage')) {

	function returnOpportunitieStage() {
		return $states = array(
			'prospecção',
			'apresentação',
			'proposta',
			'ganhamos',
			'perdemos',
		);
	}

}
// gera um botão com a formatação para PRIORIDADE da tarefa  a partir de  $model
if (!function_exists('formatPriority')) {

	function formatPriority($model) {
		switch ($model->priority) {
			case 'baixa':
				echo '<td class="td-low">baixa</td>';
				break;
			case 'média':
				echo '<td class="td-medium">média</td>';
				break;
			case 'alta':
				echo '<td class="td-high">alta</td>';
				break;
			case 'emergência':
				echo '<td class="td-emergency">emergência</td>';
				break;
		}
	}

}
// retorna métodos de pagamento
if (!function_exists('returnPaymentMethods')) {

	function returnPaymentMethods() {
		return $states = array(
			'dinheiro',
			'transferência bancária',
			'boleto',
			'cartão de crédito',
			'pix',
		);
	}

}
// retorna prioridade
if (!function_exists('returnPriorities')) {

	function returnPriorities() {
		return $states = array(
			'baixa',
			'média',
			'alta',
			'emergência',
		);
	}

}
// gera um botão com a formatação para STAGE / ETAPADA DE PROSPECÇÃO da oportunidade a partir de  $model
if (!function_exists('formatStage')) {

	function formatStage($model) {
		switch ($model->stage) {
			case 'prospecção':
				echo '<td class="td-prospecting">prospecção</td>';
				break;
			case 'apresentação':
				echo '<td class="td-presentation">apresentação</td>';
				break;
			case 'proposta':
				echo '<td class="td-proposal">proposta</td>';
				break;
			case 'ganhamos':
				echo '<td class="td-won">ganhamos</td>';
				break;
			case 'perdemos':
				echo '<td class="td-lost">perdemos</td>';
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
// gera um botão com a formatação para STATUS / SITUAÇÃO da tarefa  a partir de  $model
if (!function_exists('formatStatus')) {

	function formatStatus($model) {
		switch ($model->status) {
			case 'cancelado':
				echo '<td class="td-canceled">cancelada</td>';
				break;
			case 'fazer':
				echo '<td class="td-toDo">fazer</td>';
				break;
			case 'fazendo':
				echo '<td class="td-doing">fazendo</td>';
				break;
			case 'feito':
				echo '<td class="td-done">feito</td>';
				break;
			case 'aguardar':
				echo '<td class="td-stuck">aguardar</td>';
				break;
		}
	}

}
// gera um botão com a formatação para STATUS / SITUAÇÃO da Fatura  a partir de  $model
if (!function_exists('formatInvoiceStatus')) {

	function formatInvoiceStatus($model) {
		switch ($model->status) {
			case 'rascunho':
				echo '<td class="td-draft">rascunho</td>';
				break;
			case 'orçamento':
				echo '<td class="td-pending">orçamento</td>';
				break;
			case 'cancelada':
				echo '<td class="td-canceled">cancelada</td>';
				break;
			case 'aprovada':
				echo '<td class="td-aproved">aprovada</td>';
				break;
			case 'paga':
				echo '<td class="td-paid">paga</td>';
				break;
		}
	}

}
// retorna o STATUS / SITUAÇÃO da tarefa 
if (!function_exists('returnStatus')) {

	function returnStatus() {
		return $status = array(
			'fazer',
			'aguardar',
			'feito',
			'cancelado',
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
			'paga',
		);
	}

}
// retorna os departamentos de tarefas/jornadas
if (!function_exists('returnDepartments')) {

	function returnDepartments() {
		return $states = array(
			'desenvolvimento',
			'financeiro',
			'marketing',
			'administrativo',
			'produção',
			'atendimento',
			'vendas',
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
// retorna todos os usuários  das minhas empresas (accounts)
if (!function_exists('myUsers')) {

	function myUsers(array $relationships = null) {

		if (isset($relationships)) {
			$users = User::whereHas('accounts', function($query) {
						$query->whereIn('account_id', userAccounts());
					})
					->with($relationships)
					->join('contacts', 'contacts.id', '=', 'users.contact_id')
					->select(
							'users.id as id',
							'contacts.name as name',
					)
					->orderBy('NAME', 'ASC')
					->get();
		} else {
			$users = User::whereHas('accounts', function($query) {
						$query->whereIn('account_id', userAccounts());
					})
					->join('contacts', 'contacts.id', '=', 'users.contact_id')
					->select(
							'users.id as id',
							'contacts.name as name',
					)
					->orderBy('NAME', 'ASC')
					->get();
		}
		return $users;
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