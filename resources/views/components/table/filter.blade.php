@props([
    'action',
    'method' => 'get',
    'resetUrl' => null,
    'submitLabel' => 'FILTRAR',
    'filtersActive' => null,
    'totalFiltered' => null,
    'totalTotal' => null,
])

<form action="{{ $action }}" method="{{ $method }}" class="mb-4" id="filter">
    <div class="row g-2 align-items-end p-3 mb-4 shadow-sm rounded border-3"
        style="border-color: {{ $oppositeColor ?? '#f8f9fa' }};">
        {{ $slot }}
        <div class="col-12 mt-3">
            @if (!is_null($filtersActive) && !is_null($totalFiltered) && !is_null($totalTotal))
                @if ($filtersActive)
                    <span class="fw-bold">{{ $totalFiltered }} item(s) encontrado(s) com o filtro aplicado.</span>
                @else
                    <span class="fw-bold">{{ $totalTotal }} item(s) no total.</span>
                @endif
            @endif
        </div>
        <div class="col-auto ms-auto d-flex gap-2">
            @if ($resetUrl)
                <a class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                    href="{{ $resetUrl }}">
                    <i class="fa fa-ban" aria-hidden="true"></i>
                </a>
            @endif
            <button class="btn d-flex align-items-center justify-content-center" type="submit"
                style="background-color: {{ $principalColor ?? '#c28dbf' }}; color: #fff;">
                <i class="fa fa-filter me-1" aria-hidden="true"></i> {{ $submitLabel }}
            </button>
        </div>
    </div>
</form>
