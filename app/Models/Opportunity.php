<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model {

    protected $table = 'opportunities';
    protected $fillable = [
        'id',
        'account_id',
        'contact_id',
        'user_id',
        'company_id',
        'name',
        'description',
        'category',
        'stage',
        'price',
        'status',
        'date_start',
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

    public function invoices() {
        return $this->hasMany(Invoice::class, 'opportunity_id', 'id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'opportunity_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

// MÉTODOS PÚBLICOS
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

}
