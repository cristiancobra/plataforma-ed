<?php

if (!function_exists('shout')) {

	function shout(string $string) {
		return strtoupper($string);
	}

}

if (!function_exists('createSelect')) {

	function createSelect(array $list) {
		foreach ($list as $key => $value) {
			echo "<option value=\"$key\">$value</option><br>";
		}
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
// retorna o nome do mês selecionado
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
		return $states = array([
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
		]);
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
