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
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
                    ->get();

            $monthlys[$key] = $invoices->sum('totalPrice');

            $monthStart->add(new DateInterval("P" . $key . "M"));
            $monthEnd->add(new DateInterval("P" . $key . "M"));
        }
        return $monthlys;
    }

    // soma as faturas do TIPO recebido somando valor TOTALPRICE do ano todo
    public static function annualInvoicesTotal($year, $type) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));
//        $months = returnMonths();
//        foreach ($months as $key => $month) {
//            $monthlys[$key] = [];

        $annualInvoicesTotal = Invoice::where('account_id', auth()->user()->account_id)
                ->where('status', 'aprovada')
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
                ->sum('totalPrice');

        return $annualInvoicesTotal;
    }

    // soma o valor da categoria para cada mês
    public static function monthlysCategoriesTotal($year, $category, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

//        $dt = new DateTime("2016-01-31");

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];

            $invoices = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('status', 'aprovada')
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-t')])
                    ->with('proposal.productProposals')
                    ->get();

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $oldDay = $monthEnd->format("d");
            $monthEnd->add(new DateInterval("P28D"));

//            if ($month == 'Fevereiro') {
//                $newDay = $monthEnd->format("d");  // 3 // 28
//                if ($oldDay != $newDay) {
//                 Check if the day is changed, if so we skipped to the next month.
//                 Substract days to go back to the last day of previous month.
//                    $monthEnd->sub(new DateInterval("P" . $newDay . "D")); // 2021-02-28  // 2021-03-28
//                }
//                }
//            $monthEnd = date("Y-m-t", $monthEnd);
//            
//            function returnDates($parcelas, $ultima_data){
//    for ($i = 1; $i <= $parcelas; $i++){   
//       $date = strtotime("+$i month", strtotime($ultima_data));
//       echo date("Y-m-t", $date)."\n";
//    } 
//}
//            $oldDay = $monthEnd->format("d"); // 31 // 28
//            $newDay = $monthEnd->format("d");  // 3 // 28
//            if ($oldDay != $newDay) {
            // Check if the day is changed, if so we skipped to the next month.
            // Substract days to go back to the last day of previous month.
//                $monthEnd->sub(new DateInterval("P" . $newDay . "D")); // 2021-02-28  // 2021-03-28
//            }else{
//                $monthEnd->add(new DateInterval("P3D"));  // x // 2021-03-31
//            }

            $value = 0;
            foreach ($invoices as $invoice) {
                if ($invoice->proposal) {
                    $installment = $invoice->proposal->installment;
                    foreach ($invoice->proposal->productProposals as $productProposal) {
                        if ($productProposal->product->category == $category) {
                            $value += $productProposal->subtotalPrice / $installment;
                            $monthlys[$month] = $value;
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
                ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
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
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
                    ->with('proposal.productProposals')
                    ->get();

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $oldDay = $monthEnd->format("d");
            $monthEnd->add(new DateInterval("P28D"));

            $value = 0;
            foreach ($invoices as $invoice) {
                if ($invoice->proposal) {
                    $installment = $invoice->proposal->installment;
                    foreach ($invoice->proposal->productProposals as $productProposal) {
                        if ($productProposal->product->group == $group) {
                            $value += $productProposal->subtotalPrice / $installment;
                            $monthlys[$month] = $value;
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
                ->whereBetween('pay_day', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
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

}
