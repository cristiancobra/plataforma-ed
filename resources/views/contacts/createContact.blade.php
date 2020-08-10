@extends('layouts/create')

@section('title','Adicionar usuário')

@section('content')


                    <br><br><br><p class="titulo-branco"> Criar nova Plataforma</p>
                    <br>
                    <form action=" {{ route('user.store') }} " method="post" style="padding: 40px;color: white">
                        @csrf
                        <label for="" >Primeiro nome: </label>
                        <input type="text" name="novo_nome">
                        <br>
                        <br>
		<label for="" >Último nome: </label>
                        <input type="text" name="novo_sobrenome">
                        <br>
                        <br>
                        <label for="">Senha do usuário: </label>
                        <input type="password" name="password" value="">   
                        <br>
                        <br>
                        <input type="submit" value="Criar plataforma">

                    </form>
                </div>     

                <div class="imagem">
                    <img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
                </div>
  
@endsection