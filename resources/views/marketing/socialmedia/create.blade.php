@extends('layouts/master')

@section('title', 'REDES SOCIAIS')

@section('image-top')
    {{ asset('images/socialmedia.png') }}
@endsection

@section('description')
@endsection

@section('buttons')

    {{ createButtonList('socialmedia') }}
@endsection

@section('main')
    @if (Session::has('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
            @php
                Session::forget('failed');
            @endphp
        </div>
    @endif

    <!-- Exibir erros de validação -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <form action='{{ route('socialmedia.store') }}' method='post'>
            @csrf
            <input type='hidden' name='company_id' value='{{ old('company_id', app('request')->input('company_id')) }}'>

            <label class='labels' for='type'>TIPO:</label>
            {{ createSimpleSelect('type', 'fields', $types, old('type')) }}
            @if ($errors->has('type'))
                <span class="text-danger">{{ $errors->first('type') }}</span>
            @endif

            <label class='labels' for=''>NOME DA REDE SOCIAL:</label>
            {{ createSimpleSelect('socialmedia_name', 'fields', returnSocialmediaType(), old('socialmedia_name')) }}
            @if ($errors->has('socialmedia_name'))
                <span class="text-danger">{{ $errors->first('socialmedia_name') }}</span>
            @endif
            <br>

            <label class='labels' for=''>NOME DA PÁGINA:</label>
            <input type='text' name='name' size='20' value='{{ old('name') }}'>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
            <br>

            <label class='labels' for=''>ENDEREÇO DA PÁGINA:</label>
            <input type='text' name='URL_name' size='50' value='{{ old('URL_name') }}'>
            @if ($errors->has('URL_name'))
                <span class="text-danger">{{ $errors->first('URL_name') }}</span>
            @endif
            <br>

            <label class='labels' for=''>ENDEREÇO DO STUDIO DE CRIAÇÃO:</label>
            <input type='text' name='URL_studio' size='50' value='{{ old('URL_studio') }}'>
            @if ($errors->has('URL_studio'))
                <span class="text-danger">{{ $errors->first('URL_studio') }}</span>
            @endif
            <br>

            <label class='labels' for=''>CELULAR DA REDE SOCIAL:</label>
            <input type='text' name='socialmedia_phone' size='50' value='{{ old('socialmedia_phone') }}'>
            @if ($errors->has('socialmedia_phone'))
                <span class="text-danger">{{ $errors->first('socialmedia_phone') }}</span>
            @endif
            <br>

            <label class='labels' for=''>EMAIL DA REDE SOCIAL:</label>
            <input type='email' name='socialmedia_email' size='50' value='{{ old('socialmedia_email') }}'>
            @if ($errors->has('socialmedia_email'))
                <span class="text-danger">{{ $errors->first('socialmedia_email') }}</span>
            @endif
            <br><br>

            <!-- Análises da página (mantém os valores com old()) -->
            {{ createPageAnalysisWithOld('Possui conta Business', 'business', old('business')) }}
            {{ createPageAnalysisWithOld('Conta Business vinculada com Instagram', 'linked_instagram', old('linked_instagram')) }}
            {{ createPageAnalysisWithOld('Conta Business vinculada com Facebook', 'linked_facebook', old('linked_facebook')) }}
            {{ createPageAnalysisWithOld('Conta possui mesmo nome do site', 'same_site_name', old('same_site_name')) }}
            {{ createPageAnalysisWithOld('Apresentação da página (Biografia)', 'about', old('about')) }}
            {{ createPageAnalysisWithOld('Publica conteúdos  feed', 'feed_content', old('feed_content')) }}
            {{ createPageAnalysisWithOld('Feed organizado', 'harmonic_feed', old('harmonic_feed')) }}
            {{ createPageAnalysisWithOld('Publicações usam SEO', 'SEO_descriptions', old('SEO_descriptions')) }}
            {{ createPageAnalysisWithOld('images têm tamanho correto', 'feed_images', old('feed_images')) }}
            {{ createPageAnalysisWithOld('Publica Stories', 'stories', old('stories')) }}
            {{ createPageAnalysisWithOld('Ferramentas de interação', 'interaction', old('interaction')) }}
            {{ createPageAnalysisWithOld('Publica IGTV', 'igtv', old('igtv')) }}
            {{ createPageAnalysisWithOld('Publica Reels', 'reels', old('reels')) }}
            {{ createPageAnalysisWithOld('Possui  funcionários linkados ao perfil da empresa', 'employee_profiles', old('employee_profiles')) }}
            {{ createPageAnalysisWithOld('Perfil dos funcionários está adequado ao cargo da empresa', 'employee_profiles_cv', old('employee_profiles_cv')) }}
            {{ createPageAnalysisWithOld('Anuncia vagas de emprego', 'offers_job', old('offers_job')) }}
            {{ createPageAnalysisWithOld('Possui pasta com ideias', 'pin_content', old('pin_content')) }}
            {{ createPageAnalysisWithOld('Possui linktree', 'linktree', old('linktree')) }}
            {{ createPageAnalysisWithOld('Capa personalizada', 'image_banner', old('image_banner')) }}
            {{ createPageAnalysisWithOld('Playlists organizadas por SEO', 'organized_playlists', old('organized_playlists')) }}
            {{ createPageAnalysisWithOld('Possui link para loja virtual externa', 'liked_virtualstore', old('liked_virtualstore')) }}
            {{ createPageAnalysisWithOld('Vídeos possuem capa personalizada', 'video_banner', old('video_banner')) }}
            {{ createPageAnalysisWithOld('Vídeos possuem legendas em português', 'legend', old('legend')) }}
            {{ createPageAnalysisWithOld('Produz conteúdo exclusivo para membros', 'feed_member', old('feed_member')) }}
            {{ createPageAnalysisWithOld('Segue outros canais que tenham haver com o seu nicho', 'follow_channel', old('follow_channel')) }}
            <br>
            <label class='labels' for=''>Investimento em ADs (R$):</label>
            <input type='number' name='value_ads' step='0.01' min='0' max='999999.99' placeholder='0,00'
                value='{{ old('value_ads', '0.00') }}'>
            @if ($errors->has('value_ads'))
                <span class="text-danger">{{ $errors->first('value_ads') }}</span>
            @endif
            <br>
            <br>
            {{ createNumericFormField('Possui quantos seguidores', 'followers', old('followers')) }}
            <br>
            <br>
            {{ createNumericFormField(' Homens entre 13-17 anos', 'male_13_17', old('male_13_17')) }}
            {{ createNumericFormField('Homens entre  18-24 anos', 'male_18_24', old('male_18_24')) }}
            {{ createNumericFormField('Homens entre   24-34  anos', 'male_25_34', old('male_25_34')) }}
            {{ createNumericFormField('Homens entre  35-44 anos', 'male_35_44', old('male_35_44')) }}
            {{ createNumericFormField('Homens entre  45-54 anos', 'male_45_54', old('male_45_54')) }}
            {{ createNumericFormField('Homens entre  55-64 anos', 'male_55_65', old('male_55_65')) }}
            {{ createNumericFormField('Homens com mais de 65  anos', 'male_65', old('male_65')) }}
            <br>
            {{ createNumericFormField('Mulheres entre 13-17 anos', 'female_13_17', old('female_13_17')) }}
            {{ createNumericFormField('Mulheres entre  18-24 anos', 'female_18_24', old('female_18_24')) }}
            {{ createNumericFormField('Mulheres entre   24-34  anos', 'female_25_34', old('female_25_34')) }}
            {{ createNumericFormField('Mulheres entre  35-44 anos', 'female_35_44', old('female_35_44')) }}
            {{ createNumericFormField('Mulheres entre  45-54 anos', 'female_45_54', old('female_45_54')) }}
            {{ createNumericFormField('Mulheres entre  55-64 anos', 'female_55_65', old('female_55_65')) }}
            {{ createNumericFormField('Mulheres com mais de 65', 'female_65', old('female_65')) }}
            <br>
            {{ createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_1', old('city_followers_1')) }}
            {{ createNumericFormField('seguidores', 'number_city_followers_1', old('number_city_followers_1')) }}
            {{ createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_2', old('city_followers_2')) }}
            {{ createNumericFormField('seguidores', 'number_city_followers_2', old('number_city_followers_2')) }}
            {{ createTextFormField('Qual cidade você possui mais seguidores', 'city_followers_3', old('city_followers_3')) }}
            {{ createNumericFormField('seguidores', 'number_city_followers_3', old('number_city_followers_3')) }}
            <br>
            {{ createTextFormField('PALAVRAS CHAVES', 'keyword_1', old('keyword_1')) }}
            {{ createTextFormField('PALAVRAS CHAVES', 'keyword_2', old('keyword_2')) }}
            {{ createTextFormField('PALAVRAS CHAVES', 'keyword_3', old('keyword_3')) }}
            {{ createTextFormField('PALAVRAS CHAVES', 'keyword_4', old('keyword_4')) }}
            {{ createTextFormField('PALAVRAS CHAVES', 'keyword_5', old('keyword_5')) }}
            <br>
            <br>
            <label class='labels' for=''>STATUS:</label>
            {{ createSimpleSelect('status', 'fields', $status, old('status')) }}
            @if ($errors->has('status'))
                <span class="text-danger">{{ $errors->first('status') }}</span>
            @endif
            <br>
            <br>
            <label class='labels' for=''>Observações:</label>
            <br>
            <textarea id='observation' name='observation' rows='10' cols='90'>{{ old('observation') }}</textarea>
            @if ($errors->has('observation'))
                <span class="text-danger">{{ $errors->first('observation') }}</span>
            @endif
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
