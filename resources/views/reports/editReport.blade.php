@extends('layouts/master')

@section('title','EDITAR RELATÓRIO')

@section('image-top')
{{ asset('imagens/report.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href=" {{ route('report.index') }}">VER RELATÓRIOS</a>
@endsection

@section('main')
<form action=" {{ route('report.update', ['report' =>$report->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<label class="labels" for="" >DONO: </label>
	<select class="fields" name="user_id">
		<option value="{{ $report->users->id }}">
			{{ $report->users->name }}
		</option>
		@foreach ($users as $user)
		<option value="{{ $user->id }}">
			{{ $user->name }}
		</option>
		@endforeach
	</select>
	<br>
	<label  class="labels" for="">Nome do relatório: </label>
	<input type="text" name="name" size="20" value="{{ $report->name }}"><span class="fields"></span><br>
	<br>
	<label class="labels" for="">Data da realização: </label>
	<input class="fields" type="date" name="date">
	<br>
	<label class="labels" for="">Situação: </label>
	<select class="fields" name="status">
		<option value="pending">pendente</option>
		<option value="disable">desativado</option>
		<option value="active">ativo</option>
	</select>
	<br>
	<br>
	<label  class="labels" for="">Recomendações gerais: </label>
	<br>
	<input class="fields" type="text" name="general" style="width: 100%;height: 200px">
	<br>
	<br>
	<p class="title-reports">IDENTIDADE VISUAL </p>
	<br>
	<label class="labels" for="" >Possui logomarca: </label><br>
	<input type="radio" name="logo" value="good" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="logo" value="bad"><span class="fields">Sim, mas precisa de adequações</span><br>
	<input type="radio" name="logo" value="no"><span class="fields">Não possui</span><br>
	<br>
	<br>
	<label class="labels" for="" >Paleta de cores? [Kit de UI ]</label>
	<br>
	<input type="radio" name="palette" value="good" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="palette" value="bad"><span class="fields">Sim, mas precisa de adequações</span><br>
	<input type="radio" name="palette" value="no"><span class="fields">Não possui</span><br>
	<br>

	<!--   =========================================================  FACEBOOK ===================================================-->

	<p class="title-reports">
		<i class="fab fa-facebook-square fa-fw"></i>
		FACEBOOK
	</p>
	<br>
	<label class="labels" for="" >NOME DA PÁGINA:</label>
	<input type="text" name="FB_page_name" size="20" value="{{ $report->FB_page_name }}"><span class="fields"></span><br>
	<br>
	<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
	<input type="text" name="FB_URL_name" value="{{ $report->FB_URL_name }}" size="50"><span class="fields"></span><br>
	<br>
	<br>
	<label class="labels" for="">Possui conta Business: </label>
	<br>
	@if ($report->FB_business == "yes")
	<input type="radio" name="FB_business" value="yes" checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_business" value="no">
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_business" value="yes">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_business" value="no" checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<label class="labels" for="">Conta Business vinculada com Instagram: </label>
	<br>
	@if ($report->FB_linked_instagram == "sim" )
	<input type="radio" name="FB_linked_instagram" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_linked_instagram" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_linked_instagram" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_linked_instagram" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Conta com mesmo nome do site:</label>
	<br>
	@if ($report->FB_same_site_name == "sim" )
	<input type="radio" name="FB_same_site_name" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_same_site_name" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_same_site_name" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_same_site_name" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Apresentação da página:</label>
	<br>
	@if ($report->FB_same_site_name == "sim" )
	<input type="radio" name="FB_about" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_about" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_about" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_about" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publica conteúdos no feed:</label>
	<br>
	@if ($report->FB_feed_content == "sim" )
	<input type="radio" name="FB_feed_content" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_content" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_feed_content" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_content" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Feed organizado:</label>
	<br>
	@if ($report->FB_harmonic_feed == "sim" )
	<input type="radio" name="FB_harmonic_feed" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_harmonic_feed" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_harmonic_feed" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_harmonic_feed" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publicações usam SEO:</label>
	<br>
	@if ($report->FB_SEO_descriptions == "sim" )
	<input type="radio" name="FB_SEO_descriptions" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_SEO_descriptions" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_SEO_descriptions" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_SEO_descriptions" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Imagens têm tamanho correto:</label>
	<br>
	@if ($report->FB_feed_images == "sim" )
	<input type="radio" name="FB_feed_images" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_images" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_feed_images" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_images" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publica Stories:</label>
	<br>
	@if ($report->FB_stories == "sim" )
	<input type="radio" name="FB_stories" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_stories" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_stories" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_stories" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publicações com interação:</label>
	<br>
	@if ($report->FB_stories == "sim" )
	<input type="radio" name="FB_interaction" value="sim"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_interaction" value="não" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_interaction" value="sim" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_interaction" value="não"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Investimento em ADs:</label>
	<input type="number" name="FB_value_ads" step="10"  value="{{ $report->FB_value_ads }}">
	<br>
	<br>
	<input type="submit" class="btn btn-secondary" value="Atualizar dados">
	<br>
</form>
</div>     
@endsection