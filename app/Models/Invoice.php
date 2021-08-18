<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Http\Request;

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
                        $query->where('pay_day', '>', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->where('pay_day', '<', $request->date_end);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->group) {
                        $query->whereHas('invoiceLines', function ($query) use ($request) {
                            $query->whereHas('product', function ($query2) use ($request) {
                                $query2->where('group', $request->group);
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

    public static function monthlyRevenues($revenues) {
        $months = returnMonths();
        $year = 2021;

        foreach ($months as $key => $month) {
            $months[$key] = $revenues
                    ->whereBetween('pay_day', [date("$year-0$key-01"), date("$year-0$key-t")])
                    ->sum('installment_value');
        }
        return $months;
    }

    // soma o valor da categoria para cada mês
    public static function monthlyRevenuesCategories($year, $category) {
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];
            $invoices = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', 'receita')
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [date("$year-$key-01"), date("$year-$key-t")])
                    ->with('invoiceLines.product')
                    ->get();

            foreach ($invoices as $invoice) {
                foreach ($invoice->invoiceLines as $invoiceLine) {

                    if ($invoiceLine->product->category == $category) {

                        $monthlys[$month] = $invoiceLine->subtotalPrice;
                    }
                }
            }
        }
        return $monthlys;
    }

    // soma o valor do grupo  para cada mês
    public static function monthlyExpensesGroups($year, $group) {
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];
            $invoices = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', 'despesa')
                    ->where('trash', '!=', 1)
//                    ->whereHas('invoiceLines', function ($query) use ($group) {
//                        $query->whereHas('product', function ($query2) use ($group) {
//                            $query2->where('group', $group);
//                        });
//                    })
                    ->whereBetween('pay_day', [date("$year-$key-01"), date("$year-$key-t")])
                    ->with('invoiceLines.product')
                    ->get();

            $monthTotal = 0;
            foreach ($invoices as $invoice) {
                foreach ($invoice->invoiceLines as $invoiceLine) {

                    if ($invoiceLine->product->group == $group) {
                        $monthTotal += $invoiceLine->subtotalPrice;
                    }
                }
            }
            $monthlys[$month] = $monthTotal;
        }
        return $monthlys;
    }

    // retorna todas as horas registradas do usuário no ano
    public static function annualRevenuesCategories($year, $category) {

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', 'receita')
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$year . '-01-01', $year . '-12-31'])
                ->with('invoiceLines.product')
                ->get();

        $annual = 0;

        foreach ($invoices as $invoice) {
            foreach ($invoice->invoiceLines as $invoiceLine) {

                if ($invoiceLine->product->category == $category) {
                    $annual += $invoiceLine->subtotalPrice;
                }
            }
        }
        return $annual;
    }

    // retorna todas as horas registradas do usuário no ano
    public static function annualExpensesGroups($year, $group) {

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', 'despesa')
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$year . '-01-01', $year . '-12-31'])
                ->with('invoiceLines.product')
                ->get();

        $annual = 0;

        foreach ($invoices as $invoice) {
            foreach ($invoice->invoiceLines as $invoiceLine) {

                if ($invoiceLine->product->group == $group) {
                    $annual += $invoiceLine->subtotalPrice;
                }
            }
        }
        return $annual;
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
