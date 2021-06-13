@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{asset('imagens/socialmedia.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('socialmedia.index')}}">
    VOLTAR
</a>
@endsection

@section('main')
<div>
    <form action=" {{route('socialmedia.store')}} " method="post">
        @csrf
        <label class="labels" for="" >NOME DA REDE SOCIAL:</label>
        {{createSimpleSelect('socialmedia_name', 'fields', returnSocialmediaType(), $socialmedia->socialmedia_name)}}
        <br>
        <label class="labels" for="" >NOME DA PÁGINA: @</label>
        <input type="text" name="name" size="20"value="{{$socialmedia->name}}">
        <br>
        <label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
        <input type="text" name="URL_name" size="50"value="{{$socialmedia->URL_name}}">
        <br>
        <br>
        <label class="labels" for="" >ENDEREÇO DO STUDIO DE CRIAÇÃO:</label>
        <input type="text" name="URL_studio" size="50"value="{{$socialmedia->URL_studio}}">
        <br>
        <br>
        <label class="labels" for="" >CELULAR DA REDE SOCIAL:</label>
        <input type="text" name="socialmedia_phone" size="50"value="{{$socialmedia->socialmedia_phone}}">
        <br>
        <br>
        <label class="labels" for="" >EMAIL DA REDE SOCIAL:</label>
        <input type="text" name="socialmedia_email" size="50" value="{{$socialmedia->socialmedia_email}}">
        <br>
        <br>
        <label class="labels" for="">Possui conta Business: </label>
        <br>
        <input type="radio" name="business" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="business" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Conta Business vinculada com Instagram: </label>
        <br>
        <input type="radio" name="linked_instagram" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="linked_instagram" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Conta Business vinculada com  facebook: </label>
        <br>
        <input type="radio" name="linked_facebook" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="linked_facebook" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Conta possui mesmo nome do site: </label>
        <br>
        <input type="radio" name="same_site_name" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="same_site_name" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Apresentação da página (Biografia):</label>
        <br>
        <input type="radio" name="about" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="about" value="0" ><span class="fields">Não</span><br>
        <br>
        <label class="labels" for="">Publica conteúdos  feed:</label>
        <br>
        <input type="radio" name="feed_content" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="feed_content" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Feed organizado:</label>
        <br>
        <input type="radio" name="harmonic_feed" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="harmonic_feed" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Publicações usam SEO:</label>
        <br>
        <input type="radio" name="SEO_descriptions" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="SEO_descriptions" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Imagens têm tamanho correto:</label>
        <br>
        <input type="radio" name="feed_images" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="feed_images" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Publica Stories:</label>
        <br>
        <input type="radio" name="stories" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="stories" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Ferramentas de interação:</label>
        <br>
        <input type="radio" name="interaction" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="interaction" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Publica IGTV:</label>
        <br>
        <input type="radio" name="igtv" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="igtv" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Publica Reels:</label>
        <br>
        <input type="radio" name="reels" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="reels" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Possui  funcionários linkados ao perfil da empresa:</label>
        <br>
        <input type="radio" name="employee_profiles" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="employee_profiles" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Perfil dos funcionários está adequado ao cargo da empresa:</label>
        <br>
        <input type="radio" name="employee_profiles_cv" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="employee_profiles_cv" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Anuncia vagas de emprego:</label>
        <br>
        <input type="radio" name="offers_job" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="offers_job" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Possui pasta com ideias:</label>
        <br>
        <input type="radio" name="pin_content" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="pin_content" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Possui linktree:</label>
        <br>
        <input type="radio" name="linktree" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="linktree" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Capa personalizada:</label>
        <br>
        <input type="radio" name="image_banner" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="image_banner" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Playlists organizadas por SEO:</label>
        <br>
        <input type="radio" name="organized_playlists" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="organized_playlists" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Possui link para loja virtual externa:</label>
        <br>
        <input type="radio" name="liked_virtualstore" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="liked_virtualstore" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Vídeos possuem capa personalizada:</label>
        <br>
        <input type="radio" name="video_banner" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="video_banner" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Vídeos possuem legendas em português:</label>
        <br>
        <input type="radio" name="legend" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="legend" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Produz conteúdo exclusivo para membros:</label>
        <br>
        <input type="radio" name="feed_member" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="feed_member" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        <label class="labels" for="">Segue outros canais que tenham haver com o seu nicho:</label>
        <br>
        <input type="radio" name="follow_channel" value="1" checked="checked"><span class="fields">Sim</span>
        <br>
        <input type="radio" name="follow_channel" value="0" ><span class="fields">Não</span>
        <br>
        <br>
        {{createNumericFormField('Possui quantos seguidores', 'followers', $socialmedia->followers)}} 
        <br>
        {{createNumericFormField(' Homens entre 13-17 anos', 'male_13_17', $socialmedia->male_13_17)}} 
        {{createNumericFormField('Homens entre  18-24 anos', 'male_18_24' , $socialmedia->male_18_24)}}
        {{createNumericFormField('Homens entre   24-34  anos', 'male_25_34', $socialmedia->male_25_34)}}
        {{createNumericFormField('Homens entre  35-44 anos', 'male_35_44', $socialmedia->male_35_44)}} 
        {{createNumericFormField('Homens entre  45-54 anos', 'male_45_54', $socialmedia->male_45_54)}} 
        {{createNumericFormField('Homens entre  55-64 anos', 'male_55_65', $socialmedia->male_55_65)}} 
        {{createNumericFormField('Homens com mais de 65  anos', 'male_65', $socialmedia->male_65)}}
        <br>
        {{createNumericFormField('Mulheres entre 13-17 anos', 'female_13_17', $socialmedia->female_13_17)}}
        {{createNumericFormField('Mulheres entre  18-24 anos', 'female_18_24', $socialmedia->female_18_24)}}
        {{createNumericFormField('Mulheres entre   24-34  anos', 'female_25_34', $socialmedia->female_25_34)}}
        {{createNumericFormField('Mulheres entre  35-44 anos', 'female_35_44', $socialmedia->female_35_44)}}
        {{createNumericFormField('Mulheres entre  45-54 anos', 'female_45_54', $socialmedia->female_45_54)}} 
        {{createNumericFormField('Mulheres entre  55-64 anos', 'female_55_65', $socialmedia->female_55_65)}}
        {{createNumericFormField('Mulheres com mais de 65', 'female_65', $socialmedia->female_65)}}
        <br>
        {{createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_1', $socialmedia->city_followers_1)}}
        {{createNumericFormField('seguidores', 'number_city_followers_1', $socialmedia->number_city_followers_1)}}
        {{createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_2', $socialmedia->city_followers_2)}}
        {{createNumericFormField('seguidores', 'number_city_followers_2', $socialmedia->number_city_followers_2)}}
        {{createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_3', $socialmedia->city_followers_3)}}
        {{createNumericFormField('seguidores', 'number_city_followers_3', $socialmedia->number_city_followers_3)}}
        <br>
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_1', $socialmedia->keyword_1)}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_2', $socialmedia->keyword_2)}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_3', $socialmedia->keyword_3)}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_4', $socialmedia->keyword_4)}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_5', $socialmedia->keyword_5)}}
        <br>
        <label class="labels" for="">TIPO DA REDE SOCIAL:</label>
        {{createSimpleSelect('type', 'fields', $types)}}
        <br>
        <br>
        <label class="labels" for="">Investimento em ADs:</label>
        <input type='number' name='value_ads' step='any' style='text-align: right' size='6' value='0'>
        <br>
        <br>
        <label class="labels" for="">Observações:</label>
        <br>
        <textarea id="observations" name="observation" rows="10" cols="90"">
{{$socialmedia->observation}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('observation');
        </script>
        <br>
        <label class="labels" for="">STATUS:</label>
        {{createSimpleSelect('status', 'fields',  $status)}}
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="ATUALIZAR">
    </form>
    <br>
    <br>
</div>     
@endsection








