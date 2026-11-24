@extends('layouts/index')

@section('title', $title)

@section('image-top')
    <i class="fa fa-folder"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'project'" />

    <x-buttons.create model="project" />
@endsection



@section('filter')
    <x-table.filter :action="route('project.index')" :reset-url="route('project.index')" :total-filtered="$projects->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome do projeto" />
        <x-filter.select name="contact_id" :options="$contacts->pluck('name', 'id')->all()" placeholder="Todos os contatos" />
        <x-filter.select name="company_id" :options="$companies->pluck('name', 'id')->all()" placeholder="Todas as organizações" />
        <x-filter.select name="user_id" :options="$users->mapWithKeys(fn ($u) => [$u->id => optional($u->contact)->name])->all()" placeholder="Todos os usuários" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('shortcuts')
    @if (1 > 2)
        <x-shortcut :href="route('project.index', ['stage' => 'prospecção', 'status' => 'ativo'])" :number="$totalProspection" label="prospecções" />
        <x-shortcut :href="route('project.index', ['stage' => 'apresentação', 'status' => 'ativo'])" :number="$totalPresentation" label="apresentações" />
        <x-shortcut :href="route('project.index', ['stage' => 'proposta', 'status' => 'ativo'])" :number="$totalProposal" label="propostas" />
        <x-shortcut :href="route('project.index', ['stage' => 'contrato', 'status' => 'ativo'])" :number="$totalContract" label="contratos" />
        <x-shortcut :href="route('project.index', ['stage' => 'cobrança', 'status' => 'ativo'])" :number="$totalBill" label="cobrança" />
        <x-shortcut :href="route('project.index', ['stage' => 'produção', 'status' => 'ativo'])" :number="$totalProduction" label="produção" />
    @endif
@endsection



@section('table')
    <div class="row table-header" style="background-color: {{ $principalColor }}">
        <div class="col-1">
            RESPONSÁVEL
        </div>
        <div class="col-4">
            NOME
        </div>
        <div class="col-3">
            META
        </div>
        <div class="col-2">
            ORGANIZAÇÃO
        </div>
        <div class="col-1">
            PRAZO
        </div>
        <div class="col-1">
            SITUAÇÃO
        </div>
    </div>

    @foreach ($projects as $project)
        <div class="row table2 position-relative"
            style="
                                                                            color: {{ $principalColor }};
                                                                            border-left-color: {{ $complementaryColor }}
                                                                            ">
            <a class="stretched-link "href=" {{ route('project.show', ['project' => $project]) }}">
            </a>
            <div class="cel col-1">
                @if (isset($project->user->image))
                    <div class='profile-picture-small'>
                        <a class='white' href=' {{ route('user.show', ['user' => $project->user->id]) }}'>
                            <img src='{{ asset($project->user->image->path) }}' width='100%' height='100%'>
                        </a>
                    </div>
                @elseif(isset($project->user->contact->name))
                    <a class='white' href=' {{ route('user.show', ['user' => $project->user->id]) }}'>
                        {{ $project->user->contact->name }}
                    </a>
                @else
                    membro da equipe excluído
                @endif
            </div>
            <div class="cel col-4 justify-content-start">
                {{ $project->name }}
            </div>

            <div class="cel col-3">
                @if (isset($project->goal))
                    {{ $project->goal->name }}
                @else
                    Não possui
                @endif
            </div>

            @if (isset($project->company->name))
                <div class="cel col-2">
                    {{ $project->company->name }}
                </div>
            @else
                <div class="cel col-2">
                    Pessoa física
                </div>
            @endif
            <div class="cel col-1">
                {{ dateBr($project->date_due) }}
            </div>

            {{ formatStatus($project) }}
        </div>
    @endforeach
@endsection


@section('pagination')
    <div class="mt-3">{{ $projects->appends(request()->query())->links() }}</div>
@endsection


@section('js-scripts')
@endsection
