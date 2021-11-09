<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Opportunity extends Model {

    protected $table = 'opportunities';
    protected $fillable = [
        'id',
        'account_id',
        'contact_id',
        'user_id',
        'company_id',
        'goal_id',
        'created_at',
        'name',
        'description',
        'department',
        'category',
        'stage',
        'price',
        'status',
        'date_start',
        'date_due',
        'date_conclusion',
        'pay_day',
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


    public static function filterOpportunities(Request $request) {
        $opportunities = Opportunity::where(function ($query) use ($request) {
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

// retorna os estágios das oportunidades
    public static function listStages() {
        return $stages = array(
            'prospecção',
            'apresentação',
            'proposta',
            'contrato',
            'cobrança',
            'produção',
            'concluída',
        );
    }

// retorna os estágios das oportunidades
    public static function listStatus() {
        return $status = array(
            'negociando',
            'perdemos',
            'ganhamos',
        );
    }

// retorna os estágios das oportunidades do tipo DESENVOLVIMENTO
    public static function listStatusDevelopment() {
        return $status = array(
            'rascunho',
            'fazer',
            'concluída',
        );
    }

    public static function openOpportunities() {
        return $accountOpportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->where('stage', '!=', 'perdemos')
                ->where('stage', '!=', 'concluída')
                ->with([
                    'company',
                    'contact',
                ])
                ->orderBy('date_conclusion', 'DESC')
                ->get();
        ;
    }

    public static function openOpportunitiesDevelopment() {
        return $accountOpportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->where('department', 'desenvolvimento')
                ->where('stage', '!=', 'perdemos')
                ->where('stage', '!=', 'concluída')
                ->with([
                    'company',
                    'contact',
                ])
                ->orderBy('date_conclusion', 'DESC')
                ->get();
        ;
    }

    public static function getProjectsOfGoal($goalId) {
        return Opportunity::where('goal_id', $goalId)
//                ->where('department', 'desenvolvimento')
                ->where('trash', '!=', 1)
                ->with([
                    'tasks',
                ])
                ->orderBy('date_start', 'DESC')
                ->get();
        ;
    }

    public static function getProjects() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                ->where('department', 'desenvolvimento')
                ->where('trash', '!=', 1)
//                ->with([
//                    'company',
//                    'contact',
//                ])
                ->orderBy('date_start', 'DESC')
                ->get();
        ;
    }

    public static function countProspectings() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'prospecção')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countPresentations() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'apresentação')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countProposals() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'proposta')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countContracts() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'contrato')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countBills() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'cobrança')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countProductions() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'produção')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countCompletes() {
        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'concluída')
                        ->whereBetween('date_conclusion', [date('Y-m-01'), date('Y-m-t')])
                        ->count();
    }

    public static function countOpportunitiesWonWeek() {
        $lastWeek = date("Y-m-d", strtotime("-7 days"));

        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('status', 'ganhamos')
                        ->where('updated_at', '>=', $lastWeek)
                        ->count();
    }

    public static function countOpportunitiesLostWeek() {
        $lastWeek = date("Y-m-d", strtotime("-7 days"));

        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('status', 'perdemos')
                        ->where('updated_at', '>=', $lastWeek)
                        ->count();
    }

    public static function getOpportunitiesPresentations() {

        return Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', 'apresentação')
                        ->where('status', 'negociando')
                        ->get();
    }

    // cria uma nova OPORTUNIDADE para Empresa Digital quando uma nova conta é criada SE e o cadastro autorizar que entre em contato
    public static function registerOpportunityEd($contactEd, $companyEd) {
//        dd($contactEd);
        if ($contactEd->authorization_contact == 1) {
            $opportunityEd = new Opportunity();
            $opportunityEd->name = "$contactEd->name cadastro do site";
            $opportunityEd->account_id = 1;
            $opportunityEd->user_id = 2;
                $opportunityEd->company_id = $companyEd->id;
            $opportunityEd->contact_id = $contactEd->id;
            $opportunityEd->date_start = date('Y-m-d');
            $opportunityEd->stage = 'apresentação';
            $opportunityEd->status = 'negociando';
            $opportunityEd->save();
            
            return $opportunityEd;
        }
    }

}
