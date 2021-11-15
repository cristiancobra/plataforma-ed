<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Contact;

class Project extends Model
{
  protected $table = 'projects';
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'contact_id',
        'company_id',
        'goal_id',
        'name',
        'department',
        'date_start',
        'date_due',
        'date_conclusion',
        'description',
        'status',
        'trash',
    ];
    protected $hidden = [
    ];
    
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    
        public function goal() {
        return $this->belongsTo(Goal::class, 'goal_id', 'id');
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'opportunity_id', 'id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'opportunity_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICO


    public static function filterProjects(Request $request) {
        $opportunities = Project::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->updated_at) {
                        $query->whereBetween('updated_at', [$request->updated_at, date('Y-m-d')]);
                    }
                    if ($request->priority) {
                        $query->where('priority', $request->priority);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->stage) {
                        $query->where('stage', $request->stage);
                    }
                    if ($request->status == 'ativo') {
                        $query->where('status', '!=', 'perdemos');
                        $query->where('stage', '!=', 'concluída');
                    } elseif ($request->status) {
                        $query->where('status', $request->status);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->with(
                        'user',
                        'account',
                        'company',
                        'contact',
                        'tasks.journeys',
                )
                ->orderBy('DATE_CONCLUSION', 'ASC')
                ->paginate(20);

        $opportunities->appends([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'department' => $request->department,
            'contact_id' => $request->contact_id,
            'updated_at' => $request->updated_at,
            'company_id' => $request->company_id,
            'priority' => $request->priority,
            'type' => $request->type,
            'stage' => $request->stage,
            'status' => $request->status,
            'trash' => $request->trash
        ]);

        return $opportunities;
    }

    public static function returnStatus() {
        return [
            'ativada',
            'desativada',
            'descadastrado',
        ];
    }

    
    public static function getProjects() {
        return Project::where('account_id', auth()->user()->account_id)
                ->where('trash', '!=', 1)
//                ->with([
//                    'company',
//                    'contact',
//                ])
                ->orderBy('date_start', 'DESC')
                ->get();
        ;
    }
        
    public static function getProjectsOfGoal($goalId) {
        return Project::where('goal_id', $goalId)
//                ->where('department', 'desenvolvimento')
                ->where('trash', '!=', 1)
                ->with([
                    'tasks',
                ])
                ->orderBy('date_start', 'ASC')
                ->get();
        ;
    }
}
