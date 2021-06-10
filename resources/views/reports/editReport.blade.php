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
		<option value="{{ $report->account->id }}">
			{{ $report->account->name }}
		</option>
		@foreach ($accounts as $account)
		<option value="{{ $account->id }}">
			{{ $account->name }}
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
	<br>
	<p class="title-reports"><i class="fas fa-spinner fa-pulse fa-fw"></i>
		RECOMENDAÇÕES GERAIS
	</p>
	<br>
	<textarea id="general" name="general" rows="20" cols="90">
		{{ $report->general }}
	</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR----------------------- -->
	<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script>
CKEDITOR.replace('general');
	</script>
	<br>
	<br>
	<label  class="labels" for="">Público Alvo e Persona: </label>
	<br>
	<textarea id="target" name="target" rows="20" cols="90">
	</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
	<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script>
CKEDITOR.replace('target');
	</script>
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
	<input type="text" name="FB_page_name" size="20" value="{{ $report->FB_page_name }}"><span class="fields">{{ $report->FB_page_name }}</span><br>
	<br>
	<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
	<input type="text" name="FB_URL_name" value="{{ $report->FB_URL_name }}" size="50"><span class="fields">{{ $report->FB_URL_name }}</span><br>
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
	@if ($report->FB_linked_instagram == "yes" )
	<input type="radio" name="FB_linked_instagram" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_linked_instagram" value="no">
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_linked_instagram" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_linked_instagram" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Conta com mesmo nome do site:</label>
	<br>
	@if ($report->FB_same_site_name == "yes" )
	<input type="radio" name="FB_same_site_name" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_same_site_name" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_same_site_name" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_same_site_name" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Apresentação da página:</label>
	<br>
	@if ($report->FB_same_site_name == "yes" )
	<input type="radio" name="FB_about" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_about" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_about" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_about" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publica conteúdos no feed:</label>
	<br>
	@if ($report->FB_feed_content == "yes" )
	<input type="radio" name="FB_feed_content" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_content" value="no">
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_feed_content" value="yes">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_content" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Feed organizado:</label>
	<br>
	@if ($report->FB_harmonic_feed == "yes" )
	<input type="radio" name="FB_harmonic_feed" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_harmonic_feed" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_harmonic_feed" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_harmonic_feed" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publicações usam SEO:</label>
	<br>
	@if ($report->FB_SEO_descriptions == "yes" )
	<input type="radio" name="FB_SEO_descriptions" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_SEO_descriptions" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_SEO_descriptions" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_SEO_descriptions" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Imagens têm tamanho correto:</label>
	<br>
	@if ($report->FB_feed_images == "yes" )
	<input type="radio" name="FB_feed_images" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_images" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_feed_images" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_feed_images" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publica Stories:</label>
	<br>
	@if ($report->FB_stories == "yes" )
	<input type="radio" name="FB_stories" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_stories" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_stories" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_stories" value="no"  checked="checked">
	<span class="fields">Não</span>
	<br>
	@endif
	<br>
	<label class="labels" for="">Publicações com interação:</label>
	<br>
	@if ($report->FB_stories == "yes" )
	<input type="radio" name="FB_interaction" value="yes"  checked="checked">
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_interaction" value="no" >
	<span class="fields">Não</span>
	<br>
	@else
	<input type="radio" name="FB_interaction" value="yes" >
	<span class="fields">Sim</span>
	<br>
	<input type="radio" name="FB_interaction" value="no"  checked="checked">
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