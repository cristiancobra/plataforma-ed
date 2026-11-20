@extends('layouts/login')

@section('main')
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-6 mx-auto'>
                <div class='card' style='margin-top: 13%'>
                    <div class='card-header'>{{ __('Faça login com seu email cadastrado:') }}</div>
                    <div class='card-body'>
                        <form method='POST' action='{{ route('login') }}'>
                            @csrf

                            <div class='form-group row justify-content-center'>
                                <label for='email'
                                    class='col-md-4 col-form-label text-md-right'>{{ __('Email') }}</label>

                                <div class='col-md-6'>
                                    <input id='email' type='email'
                                        class='form-control @error('email') is-invalid @enderror' name='email'
                                        value='{{ old('email') }}' required autocomplete='email' autofocus>

                                    @error('email')
                                        <span class='invalid-feedback' role='alert'>
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class='form-group row justify-content-center'>
                                <label for='password'
                                    class='col-md-4 col-form-label text-md-right'>{{ __('Senha') }}</label>

                                <div class='col-md-6'>
                                    <div class='input-group'>
                                        <input id='password' type='password'
                                            class='form-control @error('password') is-invalid @enderror' name='password'
                                            required autocomplete='current-password'>

                                        <div class='input-group-append'>
                                            <button type='button' class='btn btn-outline-secondary' id='togglePassword'
                                                tabindex='-1'>
                                                <i class='fa fa-eye' id='togglePasswordIcon'></i>
                                            </button>
                                        </div>

                                        @error('password')
                                            <span class='invalid-feedback' role='alert'>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class='form-group row justify-content-center'>
                                <div class='col-md-6'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' name='remember' id='remember'
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class='form-check-label' for='remember'>
                                            {{ __('Permanecer logado') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group row justify-content-center mb-0'>
                                <div class='col-md-6 text-center'>
                                    <button type='submit' class='btn btn-primary'>
                                        {{ __('Entrar') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class='btn btn-link' href='{{ route('password.request') }}'>
                                            {{ __('Esqueceu sua senha?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
@endsection
