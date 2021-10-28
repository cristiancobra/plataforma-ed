@php
$empresaDigital = \App\Models\Account::find(1);

if(auth()->user() == true AND auth()->user()->account->image) {
$logo = auth()->user()->account->image->path;
}else{
$logo = $empresaDigital->image->path;
}

if(auth()->user() == true AND auth()->user()->account->principal_color) {
$principalColor = auth()->user()->account->principal_color;
}else{
$principalColor = $empresaDigital->principal_color;
}

if(auth()->user() == true AND auth()->user()->account->complementary_color) {
$complementaryColor = auth()->user()->account->complementary_color;
}else{
$complementaryColor = $empresaDigital->complementary_color;
}

if(auth()->user() == true AND auth()->user()->account->opposite_color) {
$oppositeColor = auth()->user()->account->opposite_color;
}else{
$oppositeColor = $empresaDigital->opposite_color;
}

if(auth()->user() == true) {
$lastJourney = \App\Models\Journey::myLastJourney();
$openJourney = \App\Models\Journey::myOpenJourney();
$tasksEmergency = \App\Models\Task::getTasksEmergency();
$tasksEmergencyTotal = \App\Models\Task::countTasksEmergency();
}
@endphp

<nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color: {{$principalColor}}">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">
            @guest
            <img src="{{asset('/images/logo-empresa-digital.png')}}" width="150px" height="50px">
            @endguest
            @auth
            <img src="{{asset($logo)}}" width="150px" height="50px">
            @endauth
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{__('Toggle navigation')}}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                <!-- Authentication Links -->
                @guest
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route('login') }}'>{{ __('Entrar') }}</a>
                </li>
                @if (Route::has('register'))
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route('register') }}'>{{ __('Criar conta') }}</a>
                </li>
                @endif

                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{Auth::user()->contact->name}} <span class="caret"></span>
                    </a>

                    <!--Menu do usuário logado--> 
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('user.show', Auth::user()->id)}} ">
                            <i class="fas fa-user-astronaut" style="margin-right: 4px"></i>Perfil
                        </a>
                        <a class="dropdown-item" href="{{route('logout')}}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt" style="margin-right: 4px"></i>
                            {{__('Sair')}}
                        </a>
                        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @if(isset($openJourney))
            <a class='circular-nav-button secondary'  href='{{route('task.show', ['task' => $openJourney->task_id])}}'>
                <i class="fas fa-step-forward" title='Ir para a jornada aberta' style="color:#8B2485"></i>
            </a>
            @endif
            <a class='circular-nav-button secondary'  href='{{route('task.create')}}'>
                <i class="fas fa-calendar-check" title='Criar nova tarefa' style="color:#8B2485"></i>
            </a>
            @if(count($tasksEmergency) > 0))
            <a class='circular-nav-button delete'  href='{{route('task.index', [
                                                                                                                    'status' => 'fazer',
                                                                                                                    'priority' => 'emergência',
                                                                                                                    'user_id' => auth()->user()->id,
                                                                                                                    ])}}'>
                <i class="fas fa-exclamation-triangle" title='Tarefas emergenciais' style="color:#8B2485"></i>
            <div style="
                 border-radius: 50%;
                 color:white;
                 background-color: red;
                 font-size: 11px;
                 font-weight: 600;
                 text-align: center;
                 width: 17px;
                 height: 17px;
                 margin-top: -28px;
                 margin-left: 15px;
                 padding-bottom: 5px;
                 ">
                {{$tasksEmergencyTotal}}
            </div>
            </a>
            @endif
            @endif
        </div>
    </div>
</nav>