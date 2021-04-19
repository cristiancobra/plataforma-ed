<!DOCTYPE html>
<html lang='{{str_replace('_', '-', app()->getLocale())}}'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title> @yield('title') </title>

        @include('layouts.assets')

    </head>
    <body>

        @include('layouts.navMenu')

        <div class='container-fluid'>
            <div class='row' style='background-color: #c28dbf'>
                @include('layouts.sidebar')
                <main role='main' class='col-md-9 ml-sm-auto col-lg-10 px-4' style='background-color: #EEEEEE;margin-top:30px'>

                    <div class='row' style='margin-top: 10px;padding-left: 20px;padding-right:20px;padding-top:10px;padding-bottom:10px'>
                        @include('layouts.header')
                    </div>

                    <div style='border-style: solid;border-width: 0.8px;border-color: #c28dbf;border-radius: 10px;background-color: white;padding: 50px;margin: 20px;margin-top:0px'>
                        <div class='row' style='margin-top: -10px'>
                            <div class='col-lg-8 col-sm-12'>
                                <div class='show-name'>
                                    @yield('name')
                                </div>
                            </div>
                            <div class='col-2'>
                                @yield('priority')
                            </div>
                            <div class='col-2'>
                                @yield('status')
                            </div>
                        </div>

                        <div class='row' style='margin-top: 40px'>
                            <div class='col-lg-2 col-xs-6' style='text-align: center'>
                                <div class='show-label'>
                                    CONTATO
                                </div>
                                <div class='show-label'>
                                    EMPRESA
                                </div>
                                <div class='show-label'>
                                    OPORTUNIDADE
                                </div>
                            </div>
                            <div class='col-lg-4 col-xs-6' style='text-align: center'>
                                <div class='show-field'>
                                    @if(isset($task->contact->name))
                                    {{$task->contact->name}}
                                    @else
                                    Não possui
                                    @endif
                                </div>
                                <div class='show-field'>
                                    @if(isset($task->company->name))
                                    {{$task->company->name}}
                                    @else
                                    Pessoa física
                                    @endif
                                </div>
                                <div class='show-field'>
                                    @isset($task->opportunity->id)
                                    {{$task->opportunity->name}}
                                    <button class='button-round'>
                                        <a href=' {{route('opportunity.show', ['opportunity' => $task->opportunity])}}'>
                                            <i class='fa fa-eye' style='color:white'></i>
                                        </a>
                                    </button>
                                    @else
                                    Não possui
                                    @endisset
                                </div>
                            </div>
                            <div class='col-lg-2 col-xs-6' style='text-align: center'>
                                <div class='show-label'>
                                    EMPRESA
                                </div>
                                <div class='show-label'>
                                    DEPARTAMENTO
                                </div>
                                <div class='show-label'>
                                    RESPONSÁVEL
                                </div>
                            </div>
                            <div class='col-lg-4 col-xs-6' style='text-align: center'>
                                <div class='show-field'>
                                    {{$task->account->name}}
                                </div>
                                <div class='show-field'>
                                    {{$task->department}}
                                </div>
                                <div class='show-field'>
                                    @if(isset($task->user->contact->name))
                                    {{$task->user->contact->name}}
                                    @else
                                    foi excluído
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class='row' style='margin-top: 50px'>
                            <div class='col-4' style='text-align: center'>
                                @yield('date_start')
                            </div>
                            <div class='col-4'>
                                @yield('date_due')
                            </div>
                            <div class='col-4'>
                                @yield('date_conclusion')
                            </div>
                        </div>

                        @yield('execution')

                        <div class='row' style='margin-top: 10px;text-align: right'>
                            <div class='col-12'style='text-align: right'>
                                <a class='circular-button primary' href='{{route('journey.create', [
				'taskName' => $task->name,
				'taskId' => $task->id,
				'taskAccountName' => $task->account->name,
				'taskAccountId' => $task->account->id,
				])}}'>
                                    <i class='fa fa-plus' aria-hidden='true'></i>
                                </a>
                            </div>
                        </div>

                        <div class='row' style='margin-top: 30px;text-align: right'>
                            <div class='col-12'style='text-align: right;padding-top: -10px'>
                                <form   style='text-decoration: none;color: black;display: inline-block' action='{{route('task.destroy', ['task' => $task->id])}}' method='post'>
                                    @csrf
                                    @method('delete')
                                    <a id='delete-button' class='circular-button delete' type='submit' href=''>
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </form>
                                <a class='circular-button secondary' href='{{route('task.edit', ['task' => $task->id])}}'>
                                    <i class='fa fa-edit'></i>
                                </a>
                                <a class='circular-button primary'  href='{{route('task.index')}}'>
                                    <i class='fas fa-arrow-left'></i>
                                </a>
                            </div>
                        </div>

                        <div class='row' style='margin-top: 30px'>
                            <div class='col-12'style='padding-top: -10px'>
                                Primeiro registro em: {{date('d/m/Y H:i', strtotime($task->created_at))}}
                            </div>
                        </div>

                    </div>
                </main>
                <script>
                    $("#delete-button").click(function () {
                        if (!confirm("Tem certeza que você quer apagar?")) {
                            return false;
                        }
                    });
                </script>
                @yield('js-scripts')
            </div>
        </div>
    </body>
</html>
