<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Goal extends Model
{
    protected $table = 'goals';
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'opportunity_id',
        'name',
        'description',
        'points',
        'start',
        'end',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'stage_id', 'id');
    }


// MÉTODOS PÚBLICOS
    

    public static function filterGoals(Request $request) {
        $goals = Goal::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    } else {
                        $query->where('department', '!=', 'tarefa pessoal');
                    }
                    if ($request->date_due) {
                        $query->where('date_due', '<', $request->date_due);
                    }
                    if ($request->priority) {
                        $query->where('priority', $request->priority);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status == '') {
                        // busca todos
                    } elseif ($request->status == 'fazendo') {
                        $query->where('status', 'fazer');
                        $query->whereHas('journeys');
                    } elseif ($request->status) {
                        $query->where('status', $request->status);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
//                ->with(
//                        'opportunity',
//                        'journeys',
//                        'user.contact',
//                        'user.image',
//                        'images',
//                )
//                ->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelada', 'feito')"))
                ->orderBy('date_due', 'DESC')
                ->paginate(20);

        $goals->appends([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return $goals;
    }
    

    public static function returnStatus() {
        return [
            'ativa',
            'desativada',
        ];
    }

}
