<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;

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
                    if ($request->product_id) {
                        $query->whereHas('productProposals', function ($query) use ($request) {
                            $query->where('product_id', $request->product_id);
                        });
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    } elseif ($request->variation) {
                        $query->where('type', $request->variation);
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

    public static function monthlysTotal($year, $type) {
                $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $months[$key] = Proposal::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('trash', '!=', 1)
                    ->where('type', $type)
                    ->whereBetween('pay_day', [date("$year-0$key-01"), date("$year-0$key-t")])
                    ->sum('totalPrice');
//                    ->get();
            
//            if($key == 2) {
//                
//        dd($months[$key]);
//            }
            
// adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));
        }
        return $months;
    }

    // soma o valor da categoria para cada mês
    public static function monthlysCategoriesTotal($year, $category, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];

            $proposals = Proposal::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->with('productProposals')
                    ->get();

// adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));

            $sumValue = 0;
            foreach ($proposals as $proposal) {
                foreach ($proposal->productProposals as $productProposal) {
                    if ($productProposal->product->category == $category) {
                        $value = $productProposal->subtotalPrice;
//                            echo "// $productProposal->subtotalPrice   -  $value <br>";
                        $sumValue += $value;
                        $monthlys[$month] = $sumValue;
                    }
                }
            }
        }
        return $monthlys;
    }

// soma as faturas do TIPO recebido somando valor TOTALPRICE do ano todo
    public static function annualTotal($year, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));
//        $months = returnMonths();
//        foreach ($months as $key => $month) {
//            $monthlys[$key] = [];

        $annualTotal = Proposal::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-d')])
                ->sum('totalPrice');

        return $annualTotal;
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

    
    
    // retorna o STATUS / SITUAÇÃO da fatura 
    public static function returnStatus() {

        return $status = array(
            'orçamento',
            'aprovada',
            'rascunho',
            'cancelada',
        );
    }

    // retorna todas as horas registradas do usuário no ano
    public static function annualCategoriesTotal($year, $category, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));

        $proposals = Proposal::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                ->with('productProposals')
                ->get();

        $annual = 0;

        foreach ($proposals as $proposal) {
            $installment = $proposal->installment;
            foreach ($proposal->productProposals as $productProposal) {
                if ($productProposal->product->category == $category) {
                    $annual += $productProposal->subtotalPrice;
                }
            }
        }
        return $annual;
    }
    
    
// soma o valor do grupo  para cada mês
    public static function monthlysGroupsTotal($year, $group, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];

            $proposals = Proposal::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->with('productProposals')
                    ->get();

// adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));

            $sumValue = 0;
            foreach ($proposals as $proposal) {
                    $installment = $proposal->installment;
                    foreach ($proposal->productProposals as $productProposal) {
                        if ($productProposal->product->group == $group) {
                            $value = $productProposal->subtotalPrice;
                            $sumValue += $value;
                            $monthlys[$month] = $sumValue;
                        }
                    }
            }
        }
        return $monthlys;
    }

// retorna todas as horas registradas do usuário no ano
    public static function annualGroupsTotal($year, $group, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));

        $proposals = Proposal::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                ->with('productProposals')
                ->get();

        $annual = 0;

        foreach ($proposals as $proposal) {
                $installment = $proposal->installment;
                foreach ($proposal->productProposals as $productProposal) {
                    if ($productProposal->product->group == $group) {
                        $annual += $productProposal->subtotalPrice;
                    }
                }
        }
        return $annual;
    }
    

    // verifica o saldo da proposta e determina um status
    public static function paymentsStatus($proposal) {

        $invoicesTotal = 0;
        $balanceTotal = 0;

        foreach ($proposal->invoices as $invoice) {
//            dd($invoice);
            if ($invoice->trash != 1) {
                $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                        ->where('trash', '!=', 1)
                        ->sum('value');

                $invoice->balance = $invoice->totalPrice - $invoice->paid;

                $invoicesTotal += $invoice->totalPrice;
                $proposal->balance += $invoice->balance;
            }
        }


        if ($proposal->status === 'orçamento') {
            $status = 'orçamento';
        } elseif ($proposal->balance == 0) {
            $status = 'paga';
        } elseif ($proposal->status == 'aprovada' AND $proposal->pay_day < date('Y-m-d')) {
            $status = 'atrasada';
        } elseif ($proposal->status == 'aprovada' AND $proposal->pay_day >= date('Y-m-d')) {
            $status = 'aprovada';
        } elseif ($proposal->totalPrice > $proposal->balance AND $proposal->balance > 0) {
            $status = 'parcial';
        }
        return $status;
    }

}
