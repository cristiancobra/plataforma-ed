<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionType extends Model
{
    use HasFactory;

    protected $table = 'collection_types';

    protected $fillable = [
        'account_id',
        'name',
        'category',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'type', 'id');
    }

    /**
     * Campos personalizados que os itens deste tipo preenchem.
     */
    public function fields()
    {
        return $this->belongsToMany(CollectionField::class, 'collection_field_type')
            ->orderBy('position')
            ->orderBy('label');
    }

    /**
     * Retorna um array id => name dos tipos de coleção da conta autenticada, para uso em selects.
     */
    public static function collectionTypeSelectOptions() {
        return self::where('account_id', auth()->user()->account_id)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id')
            ->toArray();
    }
}
