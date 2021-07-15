<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Journey extends Model {

    protected $table = 'journeys';
    protected $fillable = [
        'id',
        'account_id',
        'task_id',
        'user_id',
        'date',
        'description',
        'status',
        'start',
        'end',
        'duration',
    ];
    protected $hidden = [
    ];

//    RELACIONAMENTOS

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function task() {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

//    MÉTODOS PÚBLICOS
    public static function myLastJourney() {
        $journey = Journey::where('user_id', 1)
                ->orderBy('id', 'DESC')
                ->first();

        dd($journey);
    }

    public function lastJourneyTask() {
        $this->where('user_id', auth()->user()->id)
                ->orderBy('id', 'DESC')
                ->first();

        dd($this);
        $lastTask = Task::latest()
                ->where('task_id', $lastJourney->id)
                ->first();

        return $lastTask;
    }

    public static function completeJourney(Journey $journey) {
        $dateStart = new DateTime($journey->start);
        $journey->start = $dateStart->format('Y-m-d H:i:s');
        $dateEnd = new DateTime('now');
        $journey->end = $dateEnd->format('Y-m-d H:i:s');
        $journey->duration = strtotime($journey->end) - strtotime($journey->start);
        $journey->save();
    }

}
