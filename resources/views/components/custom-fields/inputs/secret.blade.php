{{-- Senha protegida: o valor guardado nunca é enviado ao formulário; em branco mantém o atual. --}}
<div class="input-group">
    <input type='password' name='{{ $name }}' id='{{ $id }}' class='form-control' value='{{ $value }}' maxlength="255"
        autocomplete="new-password"
        placeholder="{{ $hasStored ? '•••••••• (deixe em branco para manter)' : '' }}"
        @required($field->required && !$hasStored)>
    <button type="button" class="btn btn-outline-secondary" title="Mostrar/ocultar o que foi digitado"
        onclick="var i=document.getElementById('{{ $id }}'); i.type = i.type === 'password' ? 'text' : 'password'; this.firstElementChild.classList.toggle('fa-eye'); this.firstElementChild.classList.toggle('fa-eye-slash');">
        <i class="fas fa-eye"></i>
    </button>
</div>
@if ($hasStored)
    <div class="form-check mt-1">
        <input class="form-check-input" type="checkbox" name="custom_fields_clear[{{ $field->key }}]" value="1"
            id="{{ $id }}_clear">
        <label class="form-check-label small text-muted" for="{{ $id }}_clear">Apagar a senha guardada</label>
    </div>
@endif
