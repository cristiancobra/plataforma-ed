@props([
    'object' => null,
    'model' => null,
    'titleTrash' => 'Mover para lixeira',
    'titleRestore' => 'Restaurar da lixeira',
    'confirmMessage' => 'Tem certeza que deseja mover para a lixeira?',
])

@php
    // Validação
    if (!$object || !$model) {
        throw new \Exception('Componente trash requer object e model');
    }

    $isInTrash = isset($object->trash) && $object->trash == 1;
    $route = $isInTrash ? "$model.restore" : "$model.trash";
    $title = $isInTrash ? $titleRestore : $titleTrash;
    $icon = $isInTrash ? 'fa fa-recycle' : 'fa fa-trash';

    // Cores fixas: verde para restore, vermelho para trash
    $bgColor = $isInTrash ? '#28a745' : '#dc3545';

    // Confirmação apenas para trash, não para restore
    $onSubmit = !$isInTrash ? "return confirm('$confirmMessage')" : '';
@endphp

<form style='display: inline-block' action='{{ route($route, [$model => $object]) }}' method='post'
    @if ($onSubmit) onsubmit="{{ $onSubmit }}" @endif>
    @csrf
    @method('PUT')
    <button class='btn rounded-circle' title='{{ $title }}' type='submit'
        style='background-color: {{ $bgColor }}; border-color: {{ $bgColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
        {{ $attributes }}>
        <i class='{{ $icon }}'></i>
    </button>
</form>
