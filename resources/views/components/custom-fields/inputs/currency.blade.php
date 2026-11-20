<input type='text' inputmode="numeric" name='{{ $name }}' id='{{ $id }}' class='form-control' value='{{ $value }}'
    onkeyup="formatCurrencyReal('{{ $id }}')" style='text-align: right' @required($field->required)>
