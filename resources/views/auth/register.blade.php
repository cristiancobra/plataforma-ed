@extends('layouts/login')

@section('main')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cria nova conta') }}</div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf

                        <input type="hidden" name="perfil" value="dono">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Primeiro nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Sobrenome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar senha') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group row">
                            <label for="account_name" class="col-md-4 col-form-label text-md-right">{{ __('Nome da empresa') }}</label>

                            <div class="col-md-6">
                                <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" value="{{ old('account_name') }}" required autocomplete="first_name" autofocus>

                                @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class='row mt-2'>    
                            <div class='offset-2 col-10 pb-5'>
                                <br>
                                {{createCheckboxReadOnly('authorization_data', 1)}}
                                Autorizo o armazenamento dos meus dados.
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

                        <div class="form-group row mt-4 mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('CRIAR') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
