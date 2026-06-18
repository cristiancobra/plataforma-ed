<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;

    protected $table = 'loan_items';
    
    protected $fillable = [
        'loan_id',
        'collection_id',
        'condition_on_loan',
        'condition_on_return',
        'notes',
    ];

    // Relationships

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
