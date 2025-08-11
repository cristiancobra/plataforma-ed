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
        return $this->hasMany(Socialmedia::class, 'company_id', 'id');
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
                    if ($request->type == 'cliente e fornecedor') {
                        $query->where('type', $request->type)
                        ->orWhere('type', 'cliente e fornecedor');
                    } else {
                        $query->where('type', $request->type);
                    }
                })
                ->with(
                        'socialmedias',
//                        'opportunity',
//                        'journeys',
//                        'user.contact',
//                        'user.image',
                )
                ->orderBy('name', 'ASC')
                ->paginate(20);

        $items->appends([
            'name' => $request->name,
            'company' => $request->company_id,
            'type' => $request->type,
        ]);

        return $items;
    }

    // Verifica duplicidade e cria uma conta ne Empresa Digital com o mesmo nome da Empresa criada quando o usuário se registra
    public static function registerCompanyEd($request) {
        $nameChecked = Company::where('name', 'LIKE', $request->account_name)
                ->where('account_id', 1)
                ->first();
        
        if (!$nameChecked) {
            $companyEd = new Company();
            $companyEd->account_id = 1;
            $companyEd->type = 'cliente';
            $companyEd->name = $request->account_name;
            $companyEd->email = $request->email;
            $companyEd->save();
        } else {
            $companyEd = $nameChecked;
        }
        
        return $companyEd;
    }

    // cria uma EMPRESA com dados da EMPRESA DIGITAL para a nova conta registrada
    public static function registerCompanyEdCustomer($account, $empresaDigital) {
        
            $companyEdCustomer = new Company();
            $companyEdCustomer->account_id = $account->id;
            $companyEdCustomer->type = 'fornecedor';
            $companyEdCustomer->name = $empresaDigital->name;
            $companyEdCustomer->email = $empresaDigital->email;
            $companyEdCustomer->save();
        
        return $companyEdCustomer;
    }

}
