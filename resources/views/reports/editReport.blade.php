@extends('layouts/master')

@section('title','EDITAR RELATÓRIO')

@section('image-top')
{{ asset('imagens/report.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href=' {{ route('report.index') }}'>VER RELATÓRIOS</a>
@endsection

@section('main')
<form action=' {{route('report.update', ['report' =>$report->id])}} ' method='post'>
    @csrf
    @method('put')
    <label  class='labels' for=''>Nome do relatório: </label>
    <input type='text' name='name' size='20' value='{{$report->name}}'><span class='fields'></span><br>
    <br>
    <label class='labels' for=''>Data da realização: </label>
    <input class='fields' type='date' name='date' value='{{$report->date}}'>
    <br>
    <label class='labels' for=''>Situação: </label>
    {{createSimpleSelect('stataus', 'fields', $status, $report->status)}}
    <br>
    <br>
    <br>
    <p class='title-reports'><i class='fas fa-spinner fa-pulse fa-fw'></i>
        RECOMENDAÇÕES GERAIS
    </p>
    <br>
    <textarea id='general' name='general' rows='20' cols='90'>
		{{$report->general}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR----------------------- -->
    <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
    <script>
CKEDITOR.replace('general');
    </script>
    <br>
    <br>
    <label  class='labels' for=''>Público Alvo e Persona: </label>
    <br>
    <textarea id='target' name='target' rows='20' cols='90'>
{{$report->target}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
    <script>
CKEDITOR.replace('target');
    </script>
    <br>
    <input type='submit' class='btn btn-secondary' value='Atualizar dados'>
    <br>
</form>
</div>     
@endsection