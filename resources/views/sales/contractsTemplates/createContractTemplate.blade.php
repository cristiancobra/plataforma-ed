@extends('layouts/master')

@section('title','MODELOS DE CONTRATO')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contractTemplate.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
    <form action=" {{ route('contractTemplate.store') }} " method="post" style="padding: 40px;color: #874983">
        @csrf
        <label class="labels" for="" >EMPRESA: </label>
        <select name="account_id">
            @foreach ($accounts as $account)
            <option  class="fields" value="{{ $account->id }}">
                {{ $account->name }}
            </option>
            @endforeach
        </select>
        <br>
        <br>
        <label class="labels" for="" >TEXTO DO CONTRATO:</label>
        <textarea id="text" name="text" rows="20" cols="90">
		{{$contractTemplate->text}}
        </textarea>
<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('text');
        </script>
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        <select class="fields" name="status">
            <option value="pending">pendente</option>
            <option value="disable">desativado</option>
            <option value="active">ativo</option>
        </select>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
</div>     
@endsection