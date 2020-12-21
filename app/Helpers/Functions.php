<?php

if (!function_exists('shout')) {

	function shout(string $string) {
		return strtoupper($string);
	}

}
// cria as opções de um select recebendo um array com duas posições
if (!function_exists('createSelect')) {

	function createSelect(array $list) {
		foreach ($list as $key => $value) {
//			$key = print_r($key);
//			$value = print_r($value);
			echo "<option value=\"$key\">$value</option><br>";
		}
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
			$month =  "Fevereiro";
		}
		if ($number == 3) {
			$month =  "Março";
		}
		if ($number == 4) {
			$month =  "Abril";
		}
		if ($number == 5) {
			$month =  "Maio";
		}
		if ($number == 6) {
			$month =  "Junho";
		}
		if ($number == 7) {
			$month =  "Julho";
		}
		if ($number == 8) {
			$month =  "Agosto";
		}
		if ($number == 9) {
			$month =  "Setembro";
		}
		if ($number == 10) {
			$month =  "Outubro";
		}
		if ($number == 11) {
			$month =  "Novembro";
		}
		if ($number == 12) {
			$month =  "Dezembro";
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
// retorna categorias de faturas, oportunidades,  etc
if (!function_exists('returnInvoiceStatus')) {

	function returnInvoiceStatus() {
		return $states = array(
			 'enviar',
			'aprovada',
			'aprovada',
			'concluida',
		);
	}
}
// retorna os estágios das oportunidades
if (!function_exists('returnOpportunitieStage')) {

	function returnOpportunitieStage() {
		return $states = array(
			 'x',
			'x',
			'x',
			'x',
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
if (!function_exists('returnStatus')) {

	function returnStatus() {
		return $states = array(
			 'fazer',
			'fazendo',
			'aguardar',
			'feito',
			'cancelado',
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

}
