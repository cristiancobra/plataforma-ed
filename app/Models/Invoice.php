<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use App\Models\Proposal;

class Invoice extends Model {

    protected $table = 'invoices';
    protected $fillable = [
        'id',
        'identifier',
        'account_id',
        'user_id',
        'opportunity_id',
        'company_id',
        'contact_id',
        'contract_id',
        'proposal_id',
        'description',
        'date_creation',
        'pay_day',
        'expiration_date',
        'discount',
        'subtotal',
        'totalHours',
        'totalAmount',
        'totalCost',
        'totalTax_rate',
        'totalPrice',
        'totalMargin',
        'totalBalance',
        'receipt',
        'type',
        'status',
        'category',
        'receipt',
        'number_installment',
        'number_installment_total',
        'installment_value',
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

    public function proposal() {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

// MÉTODOS PÚBLICOS

    public static function filterInvoices(Request $request) {
//        $monthStart = date('Y-m-01');
//        $monthEnd = date('Y-m-t');
//        $yearStart = date('Y-01-01');
//        $yearEnd = date('Y-12-31');

        $invoices = Invoice::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->whereHas('opportunity', function ($query) use ($request) {
                            $query->where('name', 'like', "%$request->name%");
                        });
                    }
                    if ($request->date_start) {
                        $query->where('pay_day', '>=', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->where('pay_day', '<=', $request->date_end);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->group) {
                        $query->whereHas('proposal', function ($query) use ($request) {
                            $query->whereHas('productProposals', function ($query2) use ($request) {
                                $query2->whereHas('product', function ($query3) use ($request) {
                                    $query3->where('group', $request->group);
                                });
                            });
                        });
                    }
                    if ($request->category) {
                        $query->whereHas('proposal', function ($query) use ($request) {
                            $query->whereHas('productProposals', function ($query2) use ($request) {
                                $query2->whereHas('product', function ($query3) use ($request) {
                                    $query3->where('category', $request->category);
                                });
                            });
                        });
                    }
                    if ($request->status) {
                        $query->where('status', '=', $request->status);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->with([
                    'account',
                    'opportunity',
                    'invoiceLines.product',
                    'account.bankAccounts',
                    'user.contact',
                    'contract',
                    'proposal',
                ])
                ->orderBy('pay_day', 'DESC')
                ->paginate(20);
//dd($invoices);
        $invoices->appends([
            'contact_id' => $request->contact_id,
            'company_id' => $request->company_id,
            'user_id' => $request->user_id,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        foreach ($invoices as $invoice) {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->sum('value');
        }

        return $invoices;
    }

// Recebe uma fatura e soma seus pagamentos
    public static function totalPaid($invoice) {

        $sumTransactions = 0;
        foreach ($invoice->transactions as $transaction) {
            if ($transaction->trash != 1) {
                $sumTransactions += $transaction->value;
            }
        }

        return $sumTransactions;
    }

// soma as faturas do TIPO recebido gerando um array com valor total TOTALPRICE de cada mês
    public static function monthlyInvoicesTotal($year, $type) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$key] = [];

            $invoices = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-t')])
                    ->get();

            $monthlys[$key] = $invoices->sum('totalPrice');

// adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));
        }
        return $monthlys;
    }

// soma as faturas do TIPO recebido somando valor TOTALPRICE do ano todo
    public static function annualInvoicesTotal($year, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));

        $annualInvoicesTotal = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-d')])
                ->sum('totalPrice');

        return $annualInvoicesTotal;
    }

// soma as faturas do TIPO recebido somando valor TOTALPRICE do ano todo
    public static function annualInvoicesBalance($year, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));
//        $months = returnMonths();
//        foreach ($months as $key => $month) {
//            $monthlys[$key] = [];

        $annualInvoicesTotal = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-d')])
                ->sum('totalPrice');

        return $annualInvoicesTotal;
    }

// soma o valor da categoria para cada mês
    public static function monthlysCategoriesTotal($year, $category, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];

            $invoices = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->with('proposal.productProposals')
                    ->get();

//            dd($invoices);
//                      if($key == 12) {    
//dd($monthlys);
//                      }
// adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));

            $sumValue = 0;
            foreach ($invoices as $invoice) {
                if ($invoice->proposal) {
                    $installment = $invoice->proposal->installment;
                    foreach ($invoice->proposal->productProposals as $productProposal) {
                        if ($productProposal->product->category == $category) {
                            $value = $productProposal->subtotalPrice / $installment;
//                            echo "// $invoice->id - $invoice->pay_day -- $productProposal->subtotalPrice   -  $value <br>";
                            $sumValue += round($value, 2);
                            $monthlys[$month] = $sumValue;
                        }
                    }
                }
            }
        }
        return $monthlys;
    }

// retorna todas as horas registradas do usuário no ano
    public static function annualCategoriesTotal($year, $category, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                ->with('proposal.productProposals')
                ->get();

        $annual = 0;

        foreach ($invoices as $invoice) {
            if ($invoice->proposal) {
                $installment = $invoice->proposal->installment;
                foreach ($invoice->proposal->productProposals as $productProposal) {
                    if ($productProposal->product->category == $category) {
                        $annual += $productProposal->subtotalPrice / $installment;
                    }
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

            $invoices = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->with('proposal.productProposals')
                    ->get();

// adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));

            $sumValue = 0;
            foreach ($invoices as $invoice) {
                if ($invoice->proposal) {
                    $installment = $invoice->proposal->installment;
                    foreach ($invoice->proposal->productProposals as $productProposal) {
                        if ($productProposal->product->group == $group) {
                            $value = $productProposal->subtotalPrice / $installment;
                            $sumValue += $value;
                            $monthlys[$month] = $sumValue;
                        }
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

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                ->with('proposal.productProposals')
                ->get();

        $annual = 0;

        foreach ($invoices as $invoice) {
            if ($invoice->proposal) {
                $installment = $invoice->proposal->installment;
                foreach ($invoice->proposal->productProposals as $productProposal) {
                    if ($productProposal->product->group == $group) {
                        $annual += $productProposal->subtotalPrice / $installment;
                    }
                }
            }
        }
        return $annual;
    }

     // soma os pagamento/movimentações  do TIPO recebido gerando um array com valor total de cada mês
    public static function monthlyInvoicesBalance($year) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$key] = [];

            $transactions = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->get();

            $monthlys[$key] = $transactions->sum('totalPrice');

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));
        }
        return $monthlys;
    }

    
// recebe faturas e seleciona apenas as pagas
    public static function getPaidInvoices($invoices) {
        foreach ($invoices as $invoice) {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->where('trash', '!=', 1)
                    ->sum('value');
            if ($invoice->totalPrice == $invoice->paid) {
                $invoice->status = 'paga';
            } elseif ($invoice->totalPrice > $invoice->paid AND $invoice->paid > 0) {
                $invoice->status = 'parcial';
            } elseif ($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d')) {
                $invoice->status = 'atrasada';
            }
        }

        return $invoices->where('status', '!=', 'paga');
    }

    // retorna o STATUS / SITUAÇÃO da fatura 
    public static function returnStatus() {

        return $status = array(
            'rascunho',
            'orçamento',
            'cancelada',
            'aprovada',
        );
    }

    // retorna uma cor de acordo com o  STATUS / SITUAÇÃO da fatura 
    public static function statusColor($invoice) {
        if ($invoice->status == 'aprovada') {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->sum('value');
        }
        if ($invoice->paid >= $invoice->totalPrice) {
            $color = 'green';
        } elseif ($invoice->paid > 0 AND $invoice->paid <= $invoice->totalPrice) {
            $color = 'blue';
        } else {
            $color = 'white';
        }

        return $color;
    }

}
