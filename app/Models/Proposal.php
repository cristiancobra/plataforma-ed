<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model {

    protected $table = 'proposals';
    protected $fillable = [
        'id',
        'identifier',
        'account_id',
        'user_id',
        'opportunity_id',
        'company_id',
        'contact_id',
        'name',
        'date_creation',
        'expiration_date',
        'pay_day',
        'description',
        'discount',
        'totalHours',
        'totalPoints',
        'totalAmount',
        'totalCost',
        'totalTax_rate',
        'totalPrice',
        'totalMargin',
        'totalBalance',
        'receipt',
        'installment',
        'type',
        'rash',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function contract() {
        return $this->belongsTo(Contract::class);
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'proposal_id', 'id');
    }

    public function invoiceLines() {
        return $this->hasMany(InvoiceLine::class, 'invoice_id', 'id');
    }

// this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();
        self::deleting(function ($invoice) { // before delete() method call this
            $invoice->invoiceLines()->each(function ($invoiceLines) {
                $invoiceLines->delete(); // <-- direct deletion
            });
// do the rest of the cleanup...
        });
    }

    public function opportunity() {
        return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
    }

//    public function transactions() {
//        return $this->hasMany(Transaction::class);
//    }

    public function productProposals() {
        return $this->hasMany(ProductProposal::class, 'proposal_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICOS
    public static function returnTypes() {
        return $types = array(
            'receita',
            'despesa',
        );
    }

    // MÉTODOS PÚBLICOS
    public static function filterProposals($request) {
        $proposals = Proposal::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->date_start) {
                        $query->where('pay_day', '>=', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->where('pay_day', '<=', $request->date_end);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->with(
                        'opportunity',
                        'user.contact',
                        'user.image',
                )
                ->orderBy('pay_day', 'DESC')
                ->paginate(20);
                
                
        $proposals->appends([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'contact_id' => $request->contact_id,
            'company_id' => $request->company_id,
            'type' => $request->type,
            'status' => $request->status,
            'trash' => $request->trash,
        ]);

        return $proposals;
    }

    public static function monthlyRevenues($revenues) {
        $months = returnMonths();
        $year = 2021;

        foreach ($months as $key => $month) {
            $months[$key] = $revenues
                    ->whereBetween('pay_day', [date("$year-0$key-01"), date("$year-0$key-t")])
                    ->sum('totalPrice');
        }
        return $months;
    }

    public static function monthlyExpenses($expenses) {
        $months = returnMonths();
        $year = 2021;

        foreach ($months as $key => $month) {
            $months[$key] = $expenses
                    ->whereBetween('pay_day', [date("$year-0$key-01"), date("$year-0$key-t")])
                    ->sum('totalPrice');
        }
        return $months;
    }

}
