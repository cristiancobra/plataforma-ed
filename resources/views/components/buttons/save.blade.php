@props([
    'title' => 'Salvar alterações',
    'principalColor' => null,
    'formId' => null,
])

<button class='btn rounded-circle' title='{{ $title }}' type='submit'
    style='background-color: {{ $principalColor ?? '#007bff' }}; border-color: {{ $principalColor ?? '#007bff' }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    @if ($formId) form="{{ $formId }}" @endif {{ $attributes }}>
    <i class='fas fa-save'></i>
</button>
