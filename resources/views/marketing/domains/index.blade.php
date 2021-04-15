@extends('layouts/master')

@section('title','DOMÍNIOS')

@section('image-top')
{{asset('imagens/domain.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('site.index')}}">
    <i class="fa fa-globe" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('domain.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
    Você possui <span class="labels">{{$totalDomains }} produtos </span>
</p>
<br>
<table class="table-list">
    <tr>
        <td   class="table-list-header">
            DOMÍNIO 
        </td>
        <td   class="table-list-header">
            EMPRESA
        </td>
        <td   class="table-list-header">
            SITE
        </td>
        <td   class="table-list-header">
            PROVEDOR
        </td>
        <td   class="table-list-header">
            DATA DE RENOVAÇÃO:
        </td>
        <td   class="table-list-header">
            SITUAÇÃO
        </td>
    </tr>

    @foreach ($domains as $domain)
    <tr style="font-size: 14px">
        <td class="table-list-left">
            <button class="button-round">
                <a href=" {{ route('domain.show', ['domain' => $domain->id]) }}">
                    <i class='fa fa-eye' style="color:white"></i></a>
            </button>
            <button class="button-round">
                <a href=" {{ route('domain.edit', ['domain' => $domain->id]) }}">
                    <i class='fa fa-edit' style="color:white"></i></a>
            </button>
            {{$domain->name}}
        </td>
        <td class="table-list-center">
            {{$domain->account->name}}
        </td>
        <td class="table-list-center">
            {{$domain->site->name}}
            {{createButtonShow($domain->site, 'site')}}
        </td>
        <td class="table-list-center">
            {{$domain->provider}}
        </td>
        <td class="table-list-center">
            {{dateBr($domain->due_date)}}
        </td>
        {{formatStatusActive($domain)}}
    </tr>
    @endforeach
</table>
<p style="text-align: right">
    <br>
    {{ $domains->links() }}
</p>
<br>
@endsection