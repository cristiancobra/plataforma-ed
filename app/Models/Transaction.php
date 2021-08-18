<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BankAccount;
use Illuminate\Http\Request;

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
                        $query->where('company_id', $request->company_id);
                    }

                    if ($request->type) {
                        $query->where('type', '=', $request->type);
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
                ->paginate(60);

        $transactions->appends([
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'bank_account_id' => $request->bank_account_id,
        ]);

        return $transactions;
    }

}
