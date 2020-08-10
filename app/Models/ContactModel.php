<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
// Nome da conexao e da tabela existente
protected $connection = 'suitecrm';
protected $table = 'contacts';


//  The primary key associated with the table.
protected $primaryKey = 'id';

//  Indicates if the IDs are auto-incrementing.

public $incrementing = false;
public $timestamps = false;

/**
 * Tarefas do SuiteCRM, campos disponiveis (mass assignable)
 *
 */
protected $fillable = [
'id', 'first_name', 'last_name', 'created_by', 'description', 'photo', 'assigned_user_id', 'phone_home', 'phone_work', 'primary_address_street', 'primary_address_city', 'primary_address_state', 'primary_address_postalcode'
];

/**
 * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
 */
protected $hidden = [
];
}
