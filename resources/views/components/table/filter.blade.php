@props(['action', 'method' => 'get', 'resetUrl' => null, 'submitLabel' => 'FILTRAR'])

<form action="{{ $action }}" method="{{ $method }}" class="mb-4" id="filter">
    <div class="row g-2 align-items-end p-3 mb-4 shadow-sm rounded border-3"
        style="border-color: {{ $oppositeColor ?? '#f8f9fa' }};">
        {{ $slot }}
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
