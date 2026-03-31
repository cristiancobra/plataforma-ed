@extends('layouts/master')

@section('title', 'REDES SOCIAIS')

@section('image-top')
    {{ asset('images/socialmedia.png') }}
@endsection

@section('description')
@endsection

@section('buttons')
    <a class="button-primary" href="{{ route('socialmedia.index') }}">
        VOLTAR
    </a>
@endsection


@section('main')
    <br>
    <div>
        </table>
        <table class="table-list">
            <tr>
                <td class="table-list-header"style='width:85%'>
                    Informações:
                </td>
            </tr>
            <tr>
                <td class='labels'>
                    NOME DA REDE SOCIAL:<span class='fields'>{{ $socialmedia->socialmedia_name }}</span>
                </td>
            </tr>
            <tr>
                <td class='labels'>
                    NOME DA PÁGINA: @<span class='fields'>{{ $socialmedia->name }}</span>
                </td>
            </tr>
            <tr>
                <td class="labels">ENDEREÇO DA PÁGINA: https://<span class="fields">{{ $socialmedia->URL_name }}</span>
                </td>
            </tr>
            <tr>
                <td class='labels'>
                    ENDEREÇO DO STUDIO DE CRIAÇÃO: https://<span class='fields'>{{ $socialmedia->URL_studio }}</span>
                </td>
            </tr>
            <tr>
                <td class='labels'>
                    CELULAR DA REDE SOCIAL: <span class='fields'>{{ $socialmedia->socialmedia_phone }}</span>

                </td>
            </tr>
            <tr>
                <td class='labels'>
                    EMAIL DA REDE SOCIAL: <span class='fields'>{{ $socialmedia->socialmedia_email }}</span>

                </td>
            </tr>
            <table class="table-list">
                <tr>
                    <td class="table-list-header"style='width:85%'>
                        PALAVRAS CHAVE:
                    </td>
                </tr>
                <tr>
                    <br>
                <tr>
                    <td class="labels">
                        hashtag: #<span class="fields">{{ $socialmedia->keyword_1 }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">
                        hashtag: #<span class="fields">{{ $socialmedia->keyword_2 }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">
                        hashtag: #:<span class="fields">{{ $socialmedia->keyword_3 }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">
                        hashtag: #<span class="fields">{{ $socialmedia->keyword_4 }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">
                        hashtag: #:<span class="fields">{{ $socialmedia->keyword_5 }}</span>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <table class="table-list">
                <tr>
                    <td class="table-list-header" style='width:85%'>
                        Análise da página
                    </td>
                    <td class="table-list-header" style='width:10%'>
                        situação
                    </td>
                </tr>
                <tr>
                    <td class="table-list-left">Possui conta Business:</td>
                    <td class="">{{ $socialmedia->business }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Conta Business vinculada com Instagram:</td>
                    <td class="">{{ $socialmedia->linked_instagram }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Conta Business vinculada com facebook:</td>
                    <td class="">{{ $socialmedia->linked_facebook }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Conta possui mesmo nome do site:</td>
                    <td class="">{{ $socialmedia->same_site_name }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Apresentação da página (Biografia):</td>
                    <td class="">{{ $socialmedia->about }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Publica conteúdos feed:</td>
                    <td class="">{{ $socialmedia->feed_content }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Feed organizado:</td>
                    <td class="">{{ $socialmedia->harmonic_feed }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Publicações usam SEO:</td>
                    <td class="">{{ $socialmedia->SEO_descriptions }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Imagens têm tamanho correto:</td>
                    <td class="">{{ $socialmedia->feed_images }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Publica Stories:</td>
                    <td class="">{{ $socialmedia->stories }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Ferramentas de interação:</td>
                    <td class="">{{ $socialmedia->interaction }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Publica IGTV:</td>
                    <td class="">{{ $socialmedia->igtv }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Publica Reels:</td>
                    <td class="">{{ $socialmedia->reels }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Possui funcionários linkados ao perfil da empresa:</td>
                    <td class="">{{ $socialmedia->employee_profiles }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Perfil dos funcionários está adequado ao cargo da empresa:</td>
                    <td class="">{{ $socialmedia->employee_profiles_cv }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Anuncia vagas de emprego:</td>
                    <td class="">{{ $socialmedia->offers_job }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Possui pasta com ideias:</td>
                    <td class="">{{ $socialmedia->pin_content }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Possui linktree:</td>
                    <td class="">{{ $socialmedia->linktree }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Capa personalizada:</td>
                    <td class="">{{ $socialmedia->image_banner }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Playlists organizadas por SEO:</td>
                    <td class="">{{ $socialmedia->organized_playlists }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Possui link para loja virtual externa:</td>
                    <td class="">{{ $socialmedia->liked_virtualstore }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Vídeos possuem capa personalizada:</td>
                    <td class="">{{ $socialmedia->video_banner }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Vídeos possuem legendas em português:</td>
                    <td class="">{{ $socialmedia->legend }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Produz conteúdo exclusivo para membros:</td>
                    <td class="">{{ $socialmedia->feed_member }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Segue outros canais que tenham haver com o seu nicho:</td>
                    <td class="">{{ $socialmedia->follow_channel }}</td>
                </tr>
                <tr>
                    <td class="table-list-left">Investimento em ADs:</td>
                    <td class="table-list-money-income">{{ formatCurrencyReal($socialmedia->value_ads) }}</td>
                </tr>
            </table>


            <br>
            <br>
            <table class="table-list">
                <tr>
                    <td class="table-list-header"style='width:85%'>
                        Público-alvo:
                    </td>
                    <td class="table-list-header" style='width:10%'>
                        Quantidade de seguidores
                    </td>
                </tr>
                <tr>
                    <td class="table-list-left">Possui quantos seguidores:
                    </td>
                    <td class="table-list-money-income">
                        {{ $socialmedia->followers }}</td>
                </tr>
                <table class="table-list">
                    <tr>
                        <td class="table-list-header"style='width:85%'>
                            Público Masculino:
                        </td>
                        <td class="table-list-header" style='width:10%'>
                            Quantidade de seguidores
                        </td>
                    </tr>
                    <tr>

                    <tr>
                        <td class="table-list-left"> Homens entre 13-17 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_13_17 }}</td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Homens entre 18-24 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_18_24 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Homens entre 25-34 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_25_34 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Homens entre 35-44 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_35_44 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Homens entre 45-54 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_45_54 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Homens entre 55-65 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_55_65 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Homens com mais de 65 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->male_65 }}
                        </td>
                    </tr>
                    </tr>

                    <td class=" table-list-header" style= 'text-align: right'>
                        Total de Homens:
                    </td>
                    <td class=" table-list-header"style='text-align: right'>
                        {{ $socialmedia->male_13_17 +
                            $socialmedia->male_18_24 +
                            $socialmedia->male_25_34 +
                            $socialmedia->male_35_44 +
                            $socialmedia->male_45_54 +
                            $socialmedia->male_55_64 +
                            $socialmedia->male_65 }}
                    </td>
                </table>
                <br>
                <table class="table-list">
                    <tr>
                        <td class="table-list-header"style='width:85%'>
                            Público Feminino:
                        </td>
                        <td class="table-list-header" style='width:10%'>
                            Quantidade de seguidores
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td class="table-list-left">
                            Mulheres entre 13-17 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_13_17 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Mulheres entre 18-24 anos:</td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_18_24 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Mulheres entre 25-34 anos:</td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_25_34 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Mulheres entre 35-44 anos:</td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_35_44 }}
                        </td>
                    </tr>
                    </p>
                    <tr>
                        <td class="table-list-left">
                            Mulheres entre 45-54 anos:</td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_45_54 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Mulheres entre 55-65 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_55_65 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            Mulheres com mais de 65 anos:
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->female_65 }}
                        </td>
                    </tr>

                    <td class=" table-list-header"style='text-align: right'>
                        Total de Mulheres:
                    </td>
                    <td class=" table-list-header " style= 'text-align: right'>
                        {{ $socialmedia->female_13_17 +
                            $socialmedia->female_18_24 +
                            $socialmedia->female_25_34 +
                            $socialmedia->female_35_44 +
                            $socialmedia->female_45_54 +
                            $socialmedia->female_55_64 +
                            $socialmedia->female_65 }}
                    </td>
                </table>
                <br>

                <table class="table-list">
                    <tr>
                        <td class="table-list-header"style='width:85%'>
                            Cidades alvo:
                        </td>
                        <td class="table-list-header" style='width:10%'>
                            Quantidade de seguidores
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            {{ $socialmedia->city_followers_1 }}
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->number_city_followers_1 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            {{ $socialmedia->city_followers_2 }}
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->number_city_followers_2 }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-list-left">
                            {{ $socialmedia->city_followers_3 }}
                        </td>
                        <td class="table-list-money-income">
                            {{ $socialmedia->number_city_followers_3 }}
                        </td>
                    </tr>

                </table>
                <br>
                TIPO DA REDE SOCIAL:<span class="fields"> {{ $socialmedia->type }} </span>
                <br>
                <br>
                <p class="labels">
                    OBSERVAÇÕES:<span class="fields"> {!! html_entity_decode($socialmedia->observation) !!} </span>
                </p>
                <br>
                <p class="labels">
                    SITUAÇÃO:<span class="fields"> {{ $socialmedia->status }} </span>
                </p>
                <br>
                <div style="text-align:right;padding: 2%">
                    <form style="text-decoration: none;color: black;display: inline-block"
                        action="{{ route('socialmedia.destroy', ['socialmedia' => $socialmedia->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <input class="btn btn-danger" type="submit" value="APAGAR">
                    </form>
                    <a class="btn btn-secondary"
                        href=" {{ route('socialmedia.edit', ['socialmedia' => $socialmedia->id]) }}">
                        <i class='fa fa-edit'></i>
                        EDITAR
                    </a>
                    <a class="btn btn-secondary" href="{{ route('socialmedia.index') }}">
                        VOLTAR
                    </a>
                </div>
                <br>
                <br>


    </div>
@endsection
