<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    
        // Nome da conexao e da tabela existente
      protected $connection = 'suitecrm';
    protected $table = 'leads';
    
     
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
        'id', 'assigned_user_id', 'status'
    ];
    
	
	
    /**
     * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
     */
    protected $hidden = [

    ];
}
