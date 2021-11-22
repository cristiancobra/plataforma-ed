@extends('layouts/master_blank')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/site.png')}} 
@endsection

@section('buttons')

<a class="circular-button secondary"  href="{{route('page.public', ['page' => $page])}}" target='_blank'>
    <i class="fa fa-eye" aria-hidden="true"></i>
</a>
{{createButtonEdit('page', 'page', $page)}}
{{createButtonList('page')}}
@endsection


@section('main')
<div class="row justify-content-start" style="
     height: 60px;
     width: 77.6%;
     font-size: 20px;
     align-items: center;
     opacity: 0.8;
     position: absolute;
     overflow: hidden;
     background-color: {{$page->principal_color}}
">
    @if($page->logo)
    <div class="container" style="width: 250px;height: 50px">
        <img src="{{asset($page->logo->path)}}" height="100%" width="100%">
    </div>
    @else
    {{strtoupper($page->name)}}
    @endif
</div>

@if($page->image)
<div class='row pt-5' style='
     height:460px;
     background-image: url({{asset($page->image->path)}});
     background-size: cover;
     background-position: center;
     background-repeat: no-repeat;
     '>
    @else
    <div class='row pt-5' style='
     height:460px;
     background-color: {{$page->principal_color}}
     '>
    @endif
    
    <div class='col text-center'>
        <p class="mt-5 pt-5" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 38px">
            {{$page->headline}}
        </p>
    </div>
</div>

<div class='row' style='
     height:200px;
     background-color: {{$page->complementary_color}};
     '>
    <div class='col  text-center'>
        <p class="pt-5 mt-3" style="color: {{$page->opposite_color}};text-shadow: 2px 2px 4px #000000;font-size: 28px">
            {{$page->text1}}
        </p>
    </div>
</div>

<div class='row' style='
     background-color: {{$page->opposite_color}};
     '>
    <div class='col  text-center'>
        <p class="pt-5 mt-3" style="color: {{$page->principal_color}};font-size: 28px">
            {{$page->text2}}
        </p>
    </div>
</div>


<div class='row mt-5' style='
     height:200px;
     background-color: {{$page->opposite_color}};
     '>

    @if ($page->contact_first_name)
        <div class='row'>             
            <div class='offset-5 col-1'>
                <label class='labels' for='first_name'>Nome:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='first_name'>
                @if ($errors->has('first_name'))
                <span class='text-danger'>{{$errors->first('first_name')}}</span><br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_last_name)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='last_name'>Sobrenome:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='last_name'>
                @if ($errors->has('last_name'))
                <span class='text-danger'>{{$errors->first('last_name')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_email)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='email'>Email:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='email'>
                @if ($errors->has('email'))
                <span class='text-danger'>{{$errors->first('email')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_phone)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='phone'>Telefone:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='phone'>
                @if ($errors->has('phone'))
                <span class='text-danger'>{{$errors->first('phone')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_site)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='site'>Site:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='site'>
                @if ($errors->has('phone'))
                <span class='text-danger'>{{$errors->first('site')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_address)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='address'>Endereço:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='address'>
                @if ($errors->has('address'))
                <span class='text-danger'>{{$errors->first('address')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_neighborhood)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='neighborhood'>Bairro:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='neighborhood'>
                @if ($errors->has('neighborhood'))
                <span class='text-danger'>{{$errors->first('neighborhood')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_city)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='city'>Cidade:</label>
            </div>
            <div class='col-4'>
                <input type='text' name='city'>
                @if ($errors->has('neighborhood'))
                <span class='text-danger'>{{$errors->first('city')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_state)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='state'>Estado:</label>
            </div>
            <div class='col-4'>
                <input type='state' name='state'>
                @if ($errors->has('state'))
                <span class='text-danger'>{{$errors->first('state')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif

        @if($page->contact_country)
        <div class='row'>                
            <div class='offset-5 col-1'>
                <label class='labels' for='country'>País:</label>
            </div>
            <div class='col-4'>
                <input type='country' name='country'>
                @if ($errors->has('state'))
                <span class='text-danger'>{{$errors->first('country')}}</span>
                <br>
                @endif
            </div>
        </div>
        @endif
        </div>


<div class='row'>    
    <div class='offset-4 col-5 pb-5'>
        <br>
        <input type="checkbox" name="authorization_data"> Autorizo o armazenamento dos meus dados.
        @if ($errors->has('authorization_data'))
        <span class='text-danger'>{{$errors->first('authorization_data')}}</span>
        @endif
        <br>
        <input type="checkbox" name="authorization_contact"> Permito que a empresa entre em contato comigo.
        <br>
        <input type="checkbox" name="authorization_newsletter"> Quero receber notícias sobre a empresa e seus produtos/serviços.
        <br>
        * você poderá alterar isso a qualquer momento.
    </div>
    <div class='offset-4 col-4 pb-5 text-center'>
        <button class="text-button primary" type='submit'>
            CADASTRAR
        </button>
    </div>
</div>
</div>
</div>
@endsection


@section('deleteButton')

@endsection


@section('editButton', route('page.edit', ['page' => $page->id]))

@section('backButton', route('page.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{dateBr($page->created_at)}}
    </div>
</div>
@endsection