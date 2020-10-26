@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('contract.index')}}">VER CONTRATOS</a>
@endsection

@section('main')
<br>
<h1 class="name">
	CONTRATO DE PRESTAÇÃO DE SERVIÇOS
</h1>

<ol>
<li>
Objeto do contrato
<ol>
<li>
Prestação de serviços de marketing digital e infraestrutura e suporte para softwares livres, conforme descritos:

</li>
</ol>
</li>

<li>Identificação das partes
<ol>
<li>
São partes deste contrato a {{ $contract->account->name}} inscrita no CNPJ sob o XXXXXXXXXXXXX tendo como responsável , inscrito no CPF sob o nº XXXXXXXXX.
Localizada na XXXXXXXXXX, no XXXXXXXXXXXX, em XXXXXXX – XXXXXXXXXX, CEP XXXXXXXX
E XXXXXXXXXX, daqui em diante denominado apenas como cliente, inscrito no no CPF sob o nº XXXXXXXXXXXxxx. Localizado na , CEP XXXXX , XXXX
</li>
</ol>
</li>

<li> Obrigações da XXXXXX
<ol>
<li> Oferecer com qualidade os serviços, consultorias e suportes apresentados (item 1), cumprindo prazos (item 6), solicitando os dados necessários para a prestação de serviços e enviando informações para a realização de pagamentos.</li>

<li> Oferecer suporte técnico gratuito online relacionado ao mal funcionamento de programas quando estiverem relacionados a problemas de infraestrutura (servidores web e e-mail).</li>

<li> Não estão incluídos no suporte gratuito erros (bugs) relativos ao código dos softwares livres, nem erros gerados a partir de configuração / utilização errada dos softwares por parte do cliente. Esses suportes poderão ser oferecidos com cobrança de valores adicionais, de acordo com a complexidade da demanda.</li>

<li> Oferecer suporte técnico através dos canais: e-mail (contato@empresadigital.net.br) e WhatsApp (16 991792275).</li>

<li> Responder os pedidos de suporte técnico gratuito em até 48, 72 ou 96 horas, respectivamente para chamadas de alta, média e baixa prioridade. Sendo considerado alta prioridade quando os serviços estão indisponíveis, média prioridade quando os serviços estão parcialmente indisponíveis e baixa prioridade para problemas estéticos, lentidão, etc que não impeçam a utilização dos serviços.</li>

<li> Informar ao cliente, com 24 horas de antecedência, sobre interrupções necessárias para ajustes técnicos ou manutenção que demandem mais de 6 (seis) horas de duração, salvo em caso de urgência.</li>

<li> Manter o sigilo sobre o conteúdo dos “dados” não acessíveis ao público.</li>

<li> Disponibilizar backups dos dados dos clientes quando solicitados. Esses backups são gerados automaticamente apenas uma vez por semana.</li>

<li> Implementar softwares e práticas de segurança no servidor para proteger os dados do cliente contra malwares e invasão por terceiros (hackers), não sendo, no entanto, responsável em caso de ataques inevitáveis pela superação da tecnologia livre disponível no mercado.</li>

</ol>
</li>

<li>Obrigações do Cliente
<ol>
<li> Cabe ao cliente enviar textos, imagens ou fotos, necessários para o desenvolvimento do site e dos conteúdos, como informações gerais, dados da equipe, dos produtos, etc. Havendo atraso na entrega destas informações poderá haver atraso de cronograma.</li>

<li> Realizar os pagamentos nos valores e condições descritos no item 5.</li>

<li> O atraso no pagamento implicará em cobrança de multa de 2% + juros de mora de 0,33% ao dia, em acordo com os artigos 52 do Código de Defesa do Consumidor, 405 do Código Civil e 161 do Código Tributário Nacional).</li>

<li> Após o atraso de 60 dias nos pagamentos a prestadora de serviços poderá considerar que o cliente rompeu com os presentes termos, se responsabilizando com os termos descritos no item 7.</li>

<li> É de responsabilidade do cliente todos os conteúdo publicados e arquivos armazenados em nosso servidor/nuvem; cabendo somente a ele responder por qualquer tipo de infração de direitos autorais, conteúdos ilegais ou práticas ilícitas.</li>

<li> Preço e condição de pagamento</li>

<li> O valor dos serviços aqui descritos é de XXXXXXX</li>
</ol>
</li>

<li> Prazo de execução
<ol>

<li> Os prazos se iniciam a partir do pagamento do valor descrito no item 5 por parte do cliente.</li>

<li> O cliente deverá enviar as informações solicitadas pela XXX em até 2 dias. Havendo atraso na entrega de informações o cronograma poderá sofrer atrasos.</li>

<li> Eventuais alterações no cronograma podem ocorrer mediante prévia negociação das partes.</li>

<li> Atrasos ocasionados por parte do cliente não implicam em atraso ou desconto de pagamentos, exceto quando houver acordo mútuo entre as partes.</li>
</ol>
</li>

<li>Finalização do contrato
<ol>
<li>Se o cliente romper ou desistir prematuramente do contrato terá que pagar multa referente a 70% dos valores devidos.</li>
<li> A XXXXXX após recebimento de rescisão ou término do contrato, fica obrigada a entregar os dados e conteúdos (backup) ao cliente, sem que esta perca seu site ou dados de e-mail.</li>

<li> Caso a XXXXXXnão cumpra com as ações (item 3) e prazos (item 6) determinados anteriormente, poderá a parte contratante finalizar este contrato sem prejuízos de qualquer espécie.</li>
<li> Ao fim do contrato a XXXX} apresentará uma nova proposta ao cliente, garantindo a continuidade dos serviços a valores semelhantes e propostas de expansão.</li>

</ol>
</li>
<li>Condições gerais
<ol>
<li>Esse contrato entrará em vigência após sua assinatura e o pagamento do valor da entrada, conforme item 5.</li>

<li>Ambas as partes estando em acordo, assinam junto a mais uma testemunha, este documento de forma digital através do site Autentique.
</ol>
</li>
18:59
<tr>
<td class="table-list-header"><b>Foto</b></td>
<td class="table-list-header"><b>Nome </b></td>
<td class="table-list-header"><b>Descrição</b></td>
<td class="table-list-header"><b>Entrega</b></td>
<td class="table-list-header"><b>Preço</b></td>
</tr>
</ol>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($contract->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('contract.destroy', ['contract' => $contract->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('contract.edit', ['contract' => $contract->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('contract.index')}}">VOLTAR</a>
</div>
<br>

@endsection