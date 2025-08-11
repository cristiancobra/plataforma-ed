@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{ asset('images/socialmedia.png') }} 
@endsection

@section('description')


Total: <span class="labels">{{$total}}</span>
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('socialmedia.create',[
	'type' => 'minha',
])}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>

{{createButtonList('socialmedia')}}
@endsection

@section('main')
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
