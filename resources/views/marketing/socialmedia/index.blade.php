@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{ asset('imagens/socialmedia.png') }} 
@endsection

@section('description')


Total: <span class="labels">{{$total}}</span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('socialmedia.create',[
	'type' => 'minha',
])}}">
	CRIAR
</a>
@endsection

@section('main')
<form action="{{route('socialmedia.index')}} " method="post" style="text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da rede social" value="">
	<select class="select" name="account_id">
		<option  class="select" value="">
			Qualquer empresa
		</option>
		@foreach ($accounts as $account)
		<option  class="select" value="{{$account->id}}">
			{{$account->name}}
		</option>
		@endforeach
		<option  class="select" value="">
			todas
		</option>
	</select>
	{{createFilterSelect('socialmedia_name', 'select', returnSocialmediaType())}}
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header">
			NOME DA REDE SOCIAL 
		</td>
		<td   class="table-list-header">
			URL  
		</td>
		<td   class="table-list-header">
			STUDIO DE CRIAÇÃO
		</td>
		<td   class="table-list-header">
			SITUAÇÃO
		</td>
	</tr>

	@foreach ($socialmedias as $socialmedia)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<button class="button-round">
				<a href=" {{ route('socialmedia.show', ['socialmedia' => $socialmedia->id]) }}">
					<i class='fa fa-eye' style="color:white"></i>
				</a>
			</button>
			<button class="button-round">
				<a href=" {{ route('socialmedia.edit', ['socialmedia' => $socialmedia->id]) }}">
					<i class='fa fa-edit' style="color:white"></i>
				</a>
			</button>
			
			{{$socialmedia->socialmedia_name}}
		</td>
		<td class="table-list-center">
			{{$socialmedia->URL_name}} 
			<button class="button-round">
				<a href=" {{$socialmedia->URL_name}}">
					<i class='fa fa-share-alt' style="color:white"></i>
				</a>
		</td>
		<td class="table-list-center">
			
			</button>
			<button class="button-round">
				<a href=" {{ $socialmedia->URL_studio }}">
					<i class='fa fa-video' style="color:white"></i>
				</a>
			</button>
		</td>
		{{formatsocialmediaStatus($socialmedia)}}
	</tr>
	@endforeach
</table>
<p style="text-align: right">
	<br>
	{{$socialmedias->links()}}
</p>
<br>
@endsection
