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
	<input type="submit" class="btn btn-secondary" value="Atualizar dados">
</form>
</div>     
@endsection