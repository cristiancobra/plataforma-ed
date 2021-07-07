<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public static function returnTypes() {
        return $types = array(
            'cliente',
            'fornecedor',
            'cliente e fornecedor',
            'concorrente',
        );
    }

    public static function filterModel(Request $request) {
        $items = Company::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
//                    if ($request->company_id) {
//                        $query->whereHas('companies', function($query) use($request) {
//                            $query->where('company_id', $request->company_id);
//                        });
//                    }
                    if ($request->city) {
                        $query->where('city', $request->city);
                    } elseif ($request->state) {
                        $query->where('state', $request->state);
                    } elseif ($request->country) {
                        $query->where('country', $request->country);
                    }
                    if ($request->type == 'cliente' OR $request->type == 'fornecedor') {
                        $query->where('type', $request->type)
                        ->orWhere('type', 'cliente e fornecedor');
                    }
                })
//                ->with(
//                        'opportunity',
//                        'journeys',
//                        'user.contact',
//                        'user.image',
//                )
                ->orderBy('name', 'ASC')
                ->paginate(20);

        $items->appends([
            'name' => $request->name,
            'company' => $request->company_id,
            'type' => $request->type,
        ]);

        return $items;
    }

}
