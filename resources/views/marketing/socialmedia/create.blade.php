@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{asset('images/socialmedia.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('socialmedia')}}
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=' {{route('socialmedia.store')}} ' method='post'>
        @csrf
        <input type='hidden' name='company_id' value='{{app('request')->input('company_id')}}'>
        <input type='hidden' name='type' value='{{app('request')->input('type')}}'>
        <label class='labels' for='' >NOME DA REDE SOCIAL:</label>
        {{createSimpleSelect('socialmedia_name', 'fields', returnSocialmediaType())}}
        <br>
        <label class='labels' for='' >NOME DA PÁGINA:</label>
        <input type='text' name='name' size='20'><span class='fields'></span>
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class='labels' for='' >ENDEREÇO DA PÁGINA:</label>
        <input type='text' name='URL_name' size='50'><span class='fields'></span>
        @if ($errors->has('URL_name'))
        <span class="text-danger">{{$errors->first('URL_name')}}</span>
        @endif
        <br>
        <label class='labels' for='' >ENDEREÇO DO STUDIO DE CRIAÇÃO:</label>
        <input type='text' name='URL_studio' size='50'><span class='fields'></span>
        <br>
        <label class='labels' for='' >CELULAR DA REDE SOCIAL:</label>
        <input type='text' name='socialmedia_phone' size='50'><span class='fields'></span>
        <br>
        <label class='labels' for='' >EMAIL DA REDE SOCIAL:</label>
        <input type='text' name='socialmedia_email' size='50' ><span class='fields'></span>
        <br>
        <br>
        {{createPageAnalysis('Possui conta Business', 'business')}}
        {{createPageAnalysis('Conta Business vinculada com Instagram', 'linked_instagram')}}
        {{createPageAnalysis('Conta Business vinculada com Facebook', 'linked_facebook')}}
        {{createPageAnalysis('Conta possui mesmo nome do site', 'same_site_name')}}
        {{createPageAnalysis('Apresentação da página (Biografia)', 'about')}}
        {{createPageAnalysis('Publica conteúdos  feed', 'feed_content')}}
        {{createPageAnalysis('Feed organizado', 'harmonic_feed')}}
        {{createPageAnalysis('Publicações usam SEO', 'SEO_descriptions')}}
        {{createPageAnalysis('images têm tamanho correto', 'feed_images')}}
        {{createPageAnalysis('Publica Stories', 'stories')}}
        {{createPageAnalysis('Ferramentas de interação', 'interaction')}}
        {{createPageAnalysis('Publica IGTV', 'igtv')}}
        {{createPageAnalysis('Publica Reels', 'reels')}}
        {{createPageAnalysis('Possui  funcionários linkados ao perfil da empresa', 'employee_profiles')}}
        {{createPageAnalysis('Perfil dos funcionários está adequado ao cargo da empresa', 'employee_profiles_cv')}}
        {{createPageAnalysis('Anuncia vagas de emprego', 'offers_job')}}
        {{createPageAnalysis('Possui pasta com ideias', 'pin_content')}}
        {{createPageAnalysis('Possui linktree', 'linktree')}}
        {{createPageAnalysis('Capa personalizada', 'image_banner')}}
        {{createPageAnalysis('Playlists organizadas por SEO', 'organized_playlists')}}
        {{createPageAnalysis('Possui link para loja virtual externa', 'liked_virtualstore')}}
        {{createPageAnalysis('Vídeos possuem capa personalizada', 'video_banner')}}
        {{createPageAnalysis('Vídeos possuem legendas em português', 'legend')}}
        {{createPageAnalysis('Produz conteúdo exclusivo para membros', 'feed_member')}}
        {{createPageAnalysis('Segue outros canais que tenham haver com o seu nicho', 'follow_channel')}}
        <br>
        <label class='labels' for=''>Investimento em ADs:</label>
        <input type='number' name='value_ads' step='10' value='0'>
        <br>
        <br>
        {{createNumericFormField('Possui quantos seguidores', 'followers' )}} 
        <br>
        {{createNumericFormField(' Homens entre 13-17 anos', 'male_13_17' )}} 
        {{createNumericFormField('Homens entre  18-24 anos', 'male_18_24' )}} 
        {{createNumericFormField('Homens entre   24-34  anos', 'male_25_34' )}} 
        {{createNumericFormField('Homens entre  35-44 anos', 'male_35_44' )}} 
        {{createNumericFormField('Homens entre  45-54 anos', 'male_45_54' )}} 
        {{createNumericFormField('Homens entre  55-64 anos', 'male_35_44' )}} 
        {{createNumericFormField('Homens entre  18-24 anos', 'male_55_65' )}} 
        {{createNumericFormField('Homens com mais de 65  anos', 'male_65' )}} 
        <br>
        {{createNumericFormField('Mulheres entre 13-17 anos', 'female_13_17' )}} 
        {{createNumericFormField('Mulheres entre  18-24 anos', 'female_18_24' )}} 
        {{createNumericFormField('Mulheres entre   24-34  anos', 'female_25_34' )}} 
        {{createNumericFormField('Mulheres entre  35-44 anos', 'female_35_44' )}} 
        {{createNumericFormField('Mulheres entre  45-54 anos', 'female_45_54' )}} 
        {{createNumericFormField('Mulheres entre  55-64 anos', 'female_35_44' )}} 
        {{createNumericFormField('Mulheres entre  18-24 anos', 'female_55_65' )}} 
        {{createNumericFormField('Mulheres com mais de 65', 'female_65' )}}
        <br>
        {{createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_1')}}
        {{createNumericFormField('seguidores', 'number_city_followers_1' )}}
        {{createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_2')}}
        {{createNumericFormField('seguidores', 'number_city_followers_2' )}}
        {{createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_3')}}
        {{createNumericFormField('seguidores', 'number_city_followers_3' )}}
        <br>
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_1' )}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_2' )}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_3' )}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_4' )}}
        {{createTextFormField('PALAVRAS CHAVES', 'keyword_5' )}}
        <br>
        <br>
        <label class='labels' for=''>STATUS:</label>
        {{createSimpleSelect('status', 'fields', $types)}}
        <br>
        <br>
        <label class='labels' for=''>Observações:</label>
        <br>
        <textarea id='observations' name='observation' rows='10' cols='90'  value='{{old('observation')}}'>
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('observation');
        </script>
        <br>
        <br>
        <input class='btn btn-secondary' type='submit' value='CADASTRAR PÁGINA'>
    </form>
</div>     
@endsection








