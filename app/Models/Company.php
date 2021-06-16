<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

    protected $table = 'companies';
    protected $fillable = [
        'id',
        'account_id',
        'name',
        'email',
        'financial_email',
        'phone',
        'site',
        'address',
        'neighborhood',
        'city',
        'state',
        'country',
        'zip_code',
        'type',
        'employees',
        'observations',
        'cnpj',
        'instagram',
        'facebook',
        'linkedin',
        'twitter',
        'sector',
        'description',
        'client_number',
        'business_model',
        'competitive_advantage',
        'revenues',
        'value_offer',
        'status',
    ];
    protected $hidden = [
    ];

    // RELACIONAMENTOS
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contacts() {
        return $this->belongsToMany(Contact::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'id', 'company_id');
    }

    public function socialmedias() {
        return $this->hasMany(Socialmedia::class, 'id', 'company_id');
    }

    // MÉTODOS PÚBLICOS

    public static function businessModelTypes() {
        $businessModelTypes = [
            'B2B' => ' B2B - Business to Business',
            'B2C' => 'B2C - Business to Consumer',
            'B2E' => 'B2E - Business to Employee',
            'B2P' => 'B2P -  Business to Producer ',
            'B2G' => ' B2P - Business to Government',
            'B2B2C' => 'B2P - Business to Business to Consumer',
            'C2C' => 'B2P - Consumer to Consumer',
            'D2C' => 'B2P - Direct to Consumer ',
        ];
        return $businessModelTypes;
    }

}
