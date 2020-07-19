<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
// Nome da conexao e da tabela existente
protected $connection = 'akaunting';
protected $table = 'transactions';

//  The primary key associated with the table.
protected $primaryKey = 'id';

//  Indicates if the IDs are auto-incrementing.
public $incrementing = false;
public $timestamps = false;

/**
 * Transações financeiras do Akaunting, campos disponiveis (mass assignable)
  */
protected $fillable = [
'id', 'company_id', 'type', 'paid_at', 'amount', 'account_id', 'document_id', 'category_id', 'description', 'payment_method', 'deleted_at', 'contact_id'
];

/**
 * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
 */
protected $hidden = [
];
}