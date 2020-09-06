@extends('layouts/master')

@section('title','DETALHES DO PINTEREST')

@section('image-top')
{{ asset('imagens/pinterest.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('pinterest.index')}}">VER TODOS AS PÁGINAS</a>
@endsection

@section('main')
<br>
<div>
    <h1 class="name">  {{$pinterest->page_name}}  </h1>
    <br>
    <p class="labels">DONO:<span class="fields">{{ $pinterest->users->name }}</span></p>
    <p class="labels">ENDEREÇO DA PÁGINA:<span class="fields">{{ $pinterest->URL_name }}</span></p>
    <br>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
            <td   class="table-list-header" style="width: 10%"><b>situação</b></td>
        </tr>
        <tr>
            <td   class="table-list-left"><b>Possui conta Business:</b></td>
            @if ($pinterest->business === "yes")
            <td   class="button-active"><b>SIM</b></td>
            @else
            <td   class="button-delete"><b>NÃO</b></td>
            @endif
        </tr>

        <tr>
            <td   class="table-list-left"><b>Conta vinculada com site: </b></td>
            @if ($pinterest->linked_site === "yes")
            <td   class="button-active"><b>SIM</b></td>
            @else
            <td   class="button-delete"><b>NÃO</b></td>
            @endif
        </tr>
        <tr>
            <td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
            @if ($pinterest->same_site_name === "yes")
            <td   class="button-active"><b>SIM</b></td>
            @else
            <td   class="button-delete"><b>NÃO</b></td>
            @endif
        </tr>	
        <tr>
            <td   class="table-list-left"><b>Descrição no perfil:</b></td>
            @if ($pinterest->about === "yes")
            <td   class="button-active"><b>SIM</b></td>
            @else
            <td   class="button-delete"><b>NÃO</b></td>
            @endif
        </tr>	
        <tr>
            <td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
            @if ($pinterest->feed_content === "yes")
            <td   class="button-active"><b>SIM</b></td>
            @else
            <td   class="button-delete"><b>NÃO</b></td>
            @endif
        </tr>	
           <tr>
            <td   class="table-list-left"><b>Possui pasta de ideias:</b></td>
            @if ($pinterest->feed_content === "yes")
            <td   class="button-active"><b>SIM</b></td>
            @else
            <td   class="button-delete"><b>NÃO</b></td>
            @endif
        </tr>	
        <tr>
            <td   class="table-list-left"><b>Investimento em ADs:</b></td>
            <td   class="table-list-money-income"><b> R$ {{ number_format($pinterest->value_ads,2,",",".") }}</b></td>
        </tr>
    </table>

    <div style="text-align:right;padding: 2%">
        <form  style="text-decoration: none;color: black;display: inline-block" action="{{ route('pinterest.destroy', ['pinterest' => $pinterest->id]) }}" method="post">
            @csrf
            @method('delete')
            <input class="button-delete" type="submit" value="APAGAR">
        </form>
        <a class="btn btn-secondary" href=" {{ route('pinterest.edit', ['pinterest' => $pinterest->id]) }}"">
            <i class='fa fa-edit'></i>
            Editar
        </a>
    </div>
</div>
@endsection