@extends('layouts/login')

@section('main')
    <div class='container'>
        <div class='row justify-content-center align-items-center' style='min-height: calc(100vh - 76px);'>
            <div class='col-md-6 col-lg-5'>
                <div class='card shadow border-0'>
                    <div class='card-header text-white text-center py-4 border-0'
                        style='background-color: {{ $principalColor }}'>
                        <i class='fas fa-user-circle fa-2x mb-2 d-block'></i>
                        <h5 class='mb-0' style='color: #fff'>{{ __('Faça login com seu email cadastrado') }}</h5>
                    </div>
                    <div class='card-body p-4'>
                        <form method='POST' action='{{ route('login') }}'>
                            @csrf

                            <div class='form-group mb-3'>
                                <label for='email'>{{ __('Email') }}</label>

                                <div class='input-group'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'><i class='fas fa-envelope'></i></span>
                                    </div>

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

                            <div class='form-group mb-3'>
                                <label for='password'>{{ __('Senha') }}</label>

                                <div class='input-group'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'><i class='fas fa-lock'></i></span>
                                    </div>

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

                            <div class='form-group d-flex justify-content-between align-items-center mb-4'>
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='remember' id='remember'
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class='form-check-label' for='remember'>
                                        {{ __('Permanecer logado') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class='small' href='{{ route('password.request') }}'>
                                        {{ __('Esqueceu sua senha?') }}
                                    </a>
                                @endif
                            </div>

                            <button type='submit' class='btn btn-primary btn-block'
                                style='background-color: {{ $principalColor }}; border-color: {{ $principalColor }}'>
                                {{ __('Entrar') }}
                            </button>
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
