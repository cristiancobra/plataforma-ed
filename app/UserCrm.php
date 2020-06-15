<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCrm extends Model
{
    
        // Nome da conexao e da tabela existente
      protected $connection = 'suitecrm';
    protected $table = 'users';
    
     
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
        'id', 'user_name', 
    ];

    /**
     * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
     */
    protected $hidden = [

    ];
}
