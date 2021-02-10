<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\User;

if (!function_exists('createFilterSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
	function createFilterSelect($name, $class, array $options) {
		echo "<select class = '$class' name = '$name'>";
		echo "<option  class='select' value=''>
			todos
		</option>";
		foreach ($options as $option) {
			echo "<option value=\"$option\">$option</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('createSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array OPÇÕES
	function createSelect($name, $class, array $options) {
		echo "<select class = '$class' name = '$name'  value='old('$name')>";
		foreach ($options as $option) {
			echo "<option value=\"$option\">$option</option><br>";
		}
		echo "</select>";
	}

}
if (!function_exists('createDoubleSelect')) {

// cria as opções de um select recebendo NOME, CLASSE e array com DUAS POSIÇÕES de OPÇÕES
	function createDoubleSelect($name, $class, array $options) {
		echo "<select class = '$class' name = '$name' value='old('$name')>";
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
		$accountsId = Account::whereHas('users', function($query) {
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
if (!function_exists('returnOpportunitiesStage')) {

	function returnOpportunitiesStage() {
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
// gera uma coluna TD com a formatação para STATUS / SITUAÇÃO da Fatura  a partir de  $model
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
// retorna tipo da CONTA BANCÁRIA
if (!function_exists('returnBankAccountType')) {

	function returnBankAccountType() {
		return $status = array(
			'conta corrente',
			'poupança',
			'cartão de crédito',
			'investimento',
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
	function createSelectIdName($name, $class, $models) {
		echo "<select class = '$class' name = '$name'  value='old('$name')>";
		foreach ($models as $model) {
				echo "<option value=\"$model->id\">$model->name</option><br>";
		}
		echo "</select>";
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