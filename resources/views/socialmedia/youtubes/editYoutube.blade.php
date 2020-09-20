@extends('layouts/master')

@section('title','EDITAR YOUTUBE')

@section('image-top')
{{ asset('imagens/youtube.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('youtube.index')}}">VER YOUTUBES</a>
@endsection

@section('main')
<br>
<form action=" {{ route('youtube.update', ['youtube' =>$youtube->id]) }} " method="post" style="padding: 40px;color: #874983">
    @csrf
    @method('put')
    <div style="padding-left: 6%">
        <label class="labels" for="" >NOME DA PÁGINA:</label>
        <input type="text" name="page_name" size="20" value="{{ $youtube->page_name }}"><span class="fields"></span><br>
        <br>
        <label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
        <input type="text" name="URL_name" value="{{ $youtube->URL_name }}" size="50"><span class="fields"></span><br>
        <br>
        <label class="labels" for="" >DONO: </label>
        <select name="user_id">
            @foreach ($users as $user)
            <option  class="fields" value="{{ $user->id }}">
                {{ $user->name }}
            </option>
            @endforeach
        </select>
        <br>
        <br>
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
        <label class="labels" for="">Possui capa personalizada </label>
        <br>
        @if ($youtube->image_banner == "yes")
        <input type="radio" name="image_banner" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="image_banner" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="image_banner" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="image_banner" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
        @endif
        <br>
        <label class="labels" for="">Botão da capa possui link para site </label>
        <br>
        @if ($youtube->linked_site == "yes")
        <input type="radio" name="linked_site" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="linked_site" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="linked_site" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="linked_site" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
        @endif
        <br>
        <label class="labels" for="">Canal está organizado por playlist </label>
        <br>
        @if ($youtube->organized_playlists == "yes")
        <input type="radio" name="organized_playlists" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="organized_playlists" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="organized_playlists" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="organized_playlists" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
        @endif
        <br>
        <label class="labels" for="">Possui biografia: </label>
        <br>
        @if ($youtube->about == "yes")
        <input type="radio" name="about" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="about" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="about" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="about" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
        @endif
        <br>
        <label class="labels" for="">segue outros canais:</label>
        <br>
        @if ($youtube->follow_channel == "yes")
        <input type="radio" name="follow_channel" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="follow_channel" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="follow_channel" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="follow_channel" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
        @endif
        <br>
        <label class="labels" for="">conteúdo para membros:</label>
        <br>
        @if ($youtube->feed_member == "yes")
        <input type="radio" name="feed_member" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="feed_member" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="feed_member" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="feed_member" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
          @endif
        <br>
        <label class="labels" for="">loja virtual está linkada  para loja do site:</label>
        <br>
        @if ($youtube->liked_virtualstore == "yes")
        <input type="radio" name="liked_virtualstore" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="liked_virtualstore" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="liked_virtualstore" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="liked_virtualstore" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
          @endif
        <label class="labels" for="">videos possuem capa personalizada:</label>
        <br>
        @if ($youtube->video_banner == "yes")
        <input type="radio" name="video_banner" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="video_banner" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="video_banner" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="video_banner" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
          @endif


        <label class="labels" for="">Videos possuem legenda:</label>
        <br>
        @if ($youtube->legend == "yes")
        <input type="radio" name="legend" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="legend" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="legend" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="legend" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>
       <br>
        <label class="labels" for="">Títulos e descrição usam SEO:</label>
        <br>
          @endif
        @if ($youtube->seo_content == "yes")
        <input type="radio" name="seo_content" value="yes" checked="checked">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="seo_content" value="no">
        <span class="fields">Não</span>
        <br>
        @else
        <input type="radio" name="seo_content" value="yes">
        <span class="fields">Sim</span>
        <br>
        <input type="radio" name="seo_content" value="no" checked="checked">
        <span class="fields">Não</span>
        <br>

        @endif
        <br>
        <label class="labels" for="">Investimento em ADs:</label>
        <input type="number" name="value_ads" step="10"  value="{{ $youtube->value_ads }}">
        <br>
        <br>
        <label class="labels" for="">STATUS:</label>
        <select class="fields" name="status">
            <option value="{{ $youtube->status }}">{{ $youtube->status}}</option>
            @if ($youtube->status == "desativado")
            <option value="ativo">ativo</option>
            <option value="pendente">pendente</option>
            @elseif  ($youtube->status == "ativo")
            <option value="desativado">desativado</option>
            <option value="pendente">pendente</option>
            @elseif  ($youtube->status == "pendente")
            <option value="ativo">ativo</option>
            <option value="desativado">desativado</option>
            @endif
        </select>
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR YOUTUBE">
        </form>
    </div>     
    @endsection
