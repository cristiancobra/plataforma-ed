<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunities extends Model
{
       
        // Nome da conexao e da tabela existente
      protected $connection = 'suitecrm';
    protected $table = 'opportunities';
    
     
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
        'id','sales_stage','assigned_user_id','amount',
    ];
    
    /**
     * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
     */
    protected $hidden = [

    ];
}
