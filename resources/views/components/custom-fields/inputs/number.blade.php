<input type='text' inputmode="decimal" name='{{ $name }}' id='{{ $id }}' class='form-control' value='{{ $value }}'
    pattern="-?\d+([.,]\d+)?" title="Somente números (use vírgula para decimais)" @required($field->required)>
