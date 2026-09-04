<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';
    
    protected $fillable = [
        'account_id',
        'lender_user_id',
        'borrower_user_id',
        'borrower_contact_id',
        'start_date',
        'due_date',
        'destination',
        'returned_date',
        'status',
        'notes',
        'trash',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'returned_date' => 'date',
    ];

    // Relationships

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_user_id', 'id');
    }

    public function borrowerUser()
    {
        return $this->belongsTo(User::class, 'borrower_user_id', 'id');
    }

    public function borrowerContact()
    {
        return $this->belongsTo(Contact::class, 'borrower_contact_id', 'id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'loan_items')
            ->withPivot('condition_on_loan', 'condition_on_return', 'notes')
            ->withTimestamps();
    }

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }

    // Business Logic Methods

    public function isOverdue()
    {
        if ($this->returned_date) {
            return false; // Already returned
        }
        
        return Carbon::parse($this->due_date)->isPast();
    }

    public function getBorrowerName()
    {
        if ($this->borrower_user_id) {
            return $this->borrowerUser->contact->name ?? $this->borrowerUser->name;
        }
        
        if ($this->borrower_contact_id) {
            return $this->borrowerContact->name;
        }
        
        return 'N/A';
    }

    public function getBorrowerType()
    {
        if ($this->borrower_user_id) {
            return 'user';
        }
        
        if ($this->borrower_contact_id) {
            return 'contact';
        }
        
        return null;
    }

    // Scopes

    public function scopeOverdue($query)
    {
        return $query->whereNull('returned_date')
            ->where('due_date', '<', now());
    }

    public function scopeActive($query)
    {
        return $query->whereNull('returned_date')
            ->where('status', '!=', 'cancelled');
    }

    public function scopeForAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }

    public function scopeNotTrashed($query)
    {
        return $query->where('trash', 0);
    }

    // Static Methods

    public static function returnStatus()
    {
        return [
            'pending' => 'Pendente',
            'active' => 'Ativo',
            'returned' => 'Devolvido',
            'overdue' => 'Atrasado',
            'cancelled' => 'Cancelado',
        ];
    }
}
