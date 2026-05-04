@extends('layouts/index')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('buttons')
    {{ createButtonTrashIndex($trashStatus, 'collection') }}
    {{ createButtonFilter() }}
    {{ createButtonCreate('collection') }}
@endsection


@section('filter')
    <form id="filter" action="{{ route('collection.index') }}" method="get" 
        style="text-align: right; display: {{ request()->hasAny(['name', 'category', 'type', 'user_id', 'status']) ? 'block' : 'none' }};">
        <input type="text" name="name" placeholder="nome do item" value="{{ request('name') }}">
        {{ createFilterSelect('category', 'select', $categories, 'Todas as categorias') }}
        {{ createFilterSelect('type', 'select', $types, 'Todos os tipos') }}
        {{ createSelectUsers('select', $users, 'Todos os usuários') }}
        {{ createFilterSelect('status', 'select', $status, 'Todas as situações') }}
        <br>
        <a class="text-button secondary" href='{{ route('collection.index') }}'>
            LIMPAR
        </a>
        <input class="text-button primary" type="submit" value="FILTRAR">
    </form>
@endsection


@section('table')
    <div class="row table-header mb-2 mt-5" style="background-color: {{ $principalColor }}">
        <div class="col-3 text-white fw-bold">
            NOME
        </div>
        <div class="col-1 text-white fw-bold">
            IA
        </div>
        <div class="col-2 text-white fw-bold">
            TIPO
        </div>
        <div class="col-2 text-white fw-bold">
            PATRIMÔNIO
        </div>
        <div class="col-2 text-white fw-bold">
            LOCALIZAÇÃO
        </div>
        <div class="col-1 text-white fw-bold">
            RESPONSÁVEL
        </div>
        <div class="col-1 text-white fw-bold">
            SITUAÇÃO
        </div>
    </div>
    @foreach ($collections as $collection)
        <div class="row border-bottom py-2 align-items-center">
            <div class="col-3 fw-bold">
                <a class="text-dark text-decoration-none"
                    href="{{ route('collection.show', ['collection' => $collection->id]) }}">
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fa fa-eye"></i>
                    </button>
                    {{ $collection->name }}
                </a>
            </div>
            <div class="col-1">
                {{ $collection->category }}
            </div>
            <div class="col-2">
                {{ $collection->type }}
            </div>
            <div class="col-2">
                {{ $collection->patrimony_number ?? '-' }}
            </div>
            <div class="col-2">
                {{ $collection->currentLocation->location ?? '-' }}
            </div>
            <div class="col-1">
                {{ $collection->user->contact->name ?? '-' }}
            </div>
            <div class="col-1">
                @switch($collection->status)
                    @case('available')
                        <span class="badge bg-success">Disponível</span>
                    @break

                    @case('in use')
                        <span class="badge bg-primary">Em Uso</span>
                    @break

                    @case('maintenance')
                        <span class="badge bg-warning text-dark">Manutenção</span>
                    @break

                    @case('discarded')
                        <span class="badge bg-secondary">Descartado</span>
                    @break

                    @default
                        {{ $collection->status }}
                @endswitch
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    {{ $collections->appends(request()->query())->links() }}
@endsection

@section('js-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButton = document.getElementById('filter_button');
            const filterForm = document.getElementById('filter');

            filterButton.addEventListener('click', function(e) {
                e.preventDefault();
                const isHidden = window.getComputedStyle(filterForm).display === 'none';
                
                if (isHidden) {
                    filterForm.style.display = 'block';
                } else {
                    filterForm.style.display = 'none';
                }
            });
        });
    </script>
@endsection
