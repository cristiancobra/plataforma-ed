@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{asset('images/socialmedia.png')}} 
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
    <form action=" {{route('socialmedia.update', ['socialmedia' => $socialmedia])}} " method="post">
        @csrf
        @method('put')
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
        {{editPageAnalysis('Possui conta Business', 'business', $socialmedia->business)}}
        {{editPageAnalysis('Conta Business vinculada com Instagram', 'linked_instagram', $socialmedia->linked_instagram)}}
        {{editPageAnalysis('Conta Business vinculada com Facebook', 'linked_facebook', $socialmedia->linked_facebook)}}
        {{editPageAnalysis('Conta possui mesmo nome do site', 'same_site_name', $socialmedia->same_site_name)}}
        {{editPageAnalysis('Apresentação da página (Biografia)', 'about', $socialmedia->about)}}
        {{editPageAnalysis('Publica conteúdos  feed', 'feed_content', $socialmedia->feed_content)}}
        {{editPageAnalysis('Feed organizado', 'harmonic_feed', $socialmedia->harmonic_feed)}}
        {{editPageAnalysis('Publicações usam SEO', 'SEO_descriptions', $socialmedia->SEO_descriptions)}}
        {{editPageAnalysis('images têm tamanho correto', 'feed_images', $socialmedia->feed_images)}}
        {{editPageAnalysis('Publica Stories', 'stories', $socialmedia->stories)}}
        {{editPageAnalysis('Ferramentas de interação', 'interaction', $socialmedia->interaction)}}
        {{editPageAnalysis('Publica IGTV', 'igtv', $socialmedia->igtv)}}
        {{editPageAnalysis('Publica Reels', 'reels', $socialmedia->reels)}}
        {{editPageAnalysis('Possui  funcionários linkados ao perfil da empresa', 'employee_profiles', $socialmedia->employee_profiles)}}
        {{editPageAnalysis('Perfil dos funcionários está adequado ao cargo da empresa', 'employee_profiles_cv', $socialmedia->employee_profiles_cv)}}
        {{editPageAnalysis('Anuncia vagas de emprego', 'offers_job', $socialmedia->offers_job)}}
        {{editPageAnalysis('Possui pasta com ideias', 'pin_content', $socialmedia->pin_content)}}
        {{editPageAnalysis('Possui linktree', 'linktree', $socialmedia->linktree)}}
        {{editPageAnalysis('Capa personalizada', 'image_banner', $socialmedia->image_banner)}}
        {{editPageAnalysis('Playlists organizadas por SEO', 'organized_playlists', $socialmedia->organized_playlists)}}
        {{editPageAnalysis('Possui link para loja virtual externa', 'liked_virtualstore', $socialmedia->liked_virtualstore)}}
        {{editPageAnalysis('Vídeos possuem capa personalizada', 'video_banner', $socialmedia->video_banner)}}
        {{editPageAnalysis('Vídeos possuem legendas em português', 'legend', $socialmedia->legend)}}
        {{editPageAnalysis('Produz conteúdo exclusivo para membros', 'feed_member', $socialmedia->feed_member)}}
        {{editPageAnalysis('Segue outros canais que tenham haver com o seu nicho', 'follow_channel', $socialmedia->follow_channel)}}
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








