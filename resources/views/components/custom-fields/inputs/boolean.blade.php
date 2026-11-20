<div class="form-check mt-4">
    <input type="hidden" name="{{ $name }}" value="0">
    <input class="form-check-input" type="checkbox" name="{{ $name }}" id="{{ $id }}" value="1" @checked($value)>
    <label class="form-check-label" for="{{ $id }}">{{ $field->label }}</label>
</div>
