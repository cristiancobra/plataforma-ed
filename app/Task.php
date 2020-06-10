<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
        // Nome da conexao e da tabela existente
      protected $connection = 'suitecrm';
    protected $table = 'tasks';
    
     /**
     * Tarefas do SuiteCRM, campos disponiveis (mass assignable)
     *
     */
    protected $fillable = [
        'id', 'name', 'description', 'status',
    ];

    /**
     * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
     */
    protected $hidden = [

    ];
}
