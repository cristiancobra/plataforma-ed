<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

     public static function filterJourneys(Request $request) {
        $journeys = Journey::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->start) {
                        $query->where('start', '>=', $request->start);
                    }
                    if ($request->end) {
                        $query->where('end', '<=', $request->end);
                    }
                    if ($request->name) {
                        $query->whereHas('task', function($query) use ($request) {
                            $query->where('name', 'like', "%$request->name%");
                        });
                    }
                    if ($request->department) {
                        $query->whereHas('task', function($query) use ($request) {
                            $query->where('department', $request->department);
                        });
                    }
//                    if ($request->contact_id) {
//                        $query->where('contact_id', $request->contact_id);
//                    }
//                    if ($request->company_id) {
//                        $query->where('company_id', $request->company_id);
//                    }
//                    if ($request->status == '') {
//                        // busca todos
//                    } elseif ($request->status == 'fazendo') {
//                        $query->where('status', 'fazer');
//                        $query->whereHas('journeys');
//                    } elseif ($request->status) {
//                        $query->where('status', $request->status);
//                    }
                })
                ->with(
                        'account',
                        'task.opportunity',
                        'user',
                )
                ->orderBy('DATE', 'DESC')
                ->orderBy('START_TIME', 'DESC')
                ->paginate(20);

        $journeys->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        return $journeys;
    }
}
