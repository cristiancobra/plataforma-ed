<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionsGroup extends Model
{
    use HasFactory;

    protected $table = 'collections_group';

    protected $fillable = [
        'account_id',
        'name',
        'description',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Retorna um array id => name dos grupos da conta autenticada, para uso em selects.
     */
    public static function collectionsGroupSelectOptions() {
        return self::where('account_id', auth()->user()->account_id)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id')
            ->toArray();
    }
}
