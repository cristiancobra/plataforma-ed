<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use App\Models\BankAccount;

class Transaction extends Model {

    protected $table = 'transactions';
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'account_id',
        'contact_id',
        'invoice_id',
        'bank_account_id',
        'type',
        'pay_day',
        'value',
        'observations',
        'payment_method',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function bankAccount() {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICOS
    public static function filterTransactions(Request $request) {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $transactions = Transaction::where(function ($query) use ($request) {
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
                    if ($request->bank_account_id) {
                        $query->where('bank_account_id', $request->bank_account_id);
                    }
                    if ($request->company_id) {
                        $query->whereHas('invoice', function ($query) use ($request) {
                            $query->where('company_id', $request->company_id);
                        });
                    }
                    if ($request->contact_id) {
                        $query->whereHas('invoice', function ($query) use ($request) {
                            $query->where('contact_id', $request->contact_id);
                        });
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
                    'user',
                    'bankAccount',
                    'invoice',
                    'invoice.company',
                    'invoice.opportunity',
                ])
                ->orderBy('pay_day', 'DESC')
                ->paginate(100);

        $transactions->appends([
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'type' => $request->type,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'bank_account_id' => $request->bank_account_id,
        ]);

        return $transactions;
    }

    // soma os pagamento/movimentações  do TIPO recebido gerando um array com valor total de cada mês
    public static function monthlyTransactionsTotal($year, $type) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$key] = [];

            $transactions = Transaction::where('account_id', auth()->user()->account_id)
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->get();
            

            $monthlys[$key] = $transactions->sum('value');

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));
        }
//            dd($monthlys);
        return $monthlys;
    }

    // soma os pagamento/movimentações  do TIPO recebido gerando um array com valor total de cada mês
    public static function monthlyTransactionsBalance($year) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$key] = [];

            $transactions = Transaction::where('account_id', auth()->user()->account_id)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->get();

            $monthlys[$key] = $transactions->sum('value');

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));
        }
        return $monthlys;
    }

    // soma o valor dos pagamento da categoria para cada mês
    public static function monthlysCategoriesTotal($year, $category, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];

            $transactions = Transaction::where('account_id', auth()->user()->account_id)
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->with('invoice.proposal.productProposals')
                    ->get();

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));

            $value = 0;
            foreach ($transactions as $transaction) {
                if ($transaction->invoice) {
                    $installment = $transaction->invoice->proposal->installment;
                    foreach ($transaction->invoice->proposal->productProposals as $productProposal) {
                        if ($productProposal->product->category == $category) {
                            $value += $transaction->value / $installment;
                            $monthlys[$month] = $value;
                        }
                    }
                }
            }
        }
        return $monthlys;
    }

    // soma o valor do grupo  para cada mês
    public static function monthlysGroupsTotal($year, $group, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-01-t"));
        $months = returnMonths();

        foreach ($months as $key => $month) {
            $monthlys[$month] = [];

            $transactions = Transaction::where('account_id', auth()->user()->account_id)
                    ->where('type', $type)
                    ->where('trash', '!=', 1)
                    ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-t')])
                    ->with('invoice.proposal.productProposals')
                    ->get();

            // adiciona 1 mes com prevenção de erro no ultimo dia do mês
            $monthStart->add(new DateInterval("P1M"));
            $monthEnd->add(new DateInterval("P28D"));

            $value = 0;
            foreach ($transactions as $transaction) {
//                dd($transaction);
                if (isset($transaction->invoice->proposal)) {
                    $installment = $transaction->invoice->proposal->installment;
                    foreach ($transaction->invoice->proposal->productProposals as $productProposal) {
                        if ($productProposal->product->group == $group) {
                            $value += $transaction->value;
                            $monthlys[$month] = $value;
//                            echo $productProposal->product->name . "valor:   " . formatCurrency($value) . "<br>";
                        }
                    }
                }
            }
        }
        return $monthlys;
    }
    
    
// soma as movimentações  do TIPO recebido somando valor VALUE do ano todo
    public static function annualTotal($year, $type = null) {
        $monthStart = new DateTime(date("$year-01-01"));
        $monthEnd = new DateTime(date("$year-12-t"));

        $annualTotal = Transaction::where('account_id', auth()->user()->account_id)
                ->where('type', $type)
                ->where('trash', '!=', 1)
                ->whereBetween('pay_day', [$monthStart->format('Y-m-01'), $monthEnd->format('Y-m-d')])
                ->sum('value');

        return $annualTotal;
    }
    

    public static function returnTypes() {
        return [
            'entradas',
            'saídas',
            'transferência entre minhas contas',
        ];
    }

}
