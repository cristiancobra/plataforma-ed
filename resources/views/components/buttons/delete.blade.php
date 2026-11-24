{{-- Botão circular vermelho que APAGA definitivamente (método DELETE), com confirmação em modal.
     Para mover à lixeira use x-buttons.trash. Uso: <x-buttons.delete :action="route('site.destroy', ['site' => $site])" /> --}}
@props([
    'action',
    'title' => 'Apagar',
    'confirm' => 'Tem certeza que deseja apagar? Esta ação não pode ser desfeita.',
    'confirmTitle' => 'Apagar',
    'confirmLabel' => 'Apagar',
])

<form style='display: inline-block' action='{{ $action }}' method='post' data-confirm="{{ $confirm }}"
    data-confirm-title="{{ $confirmTitle }}" data-confirm-label="{{ $confirmLabel }}">
    @csrf
    @method('DELETE')
    <button class='btn rounded-circle' title='{{ $title }}' type='submit'
        style='background-color: #dc3545; border-color: #dc3545; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
        {{ $attributes }}>
        <i class='fa fa-trash'></i>
    </button>
</form>
