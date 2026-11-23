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
        'field_of_activity_1',
        'field_of_activity_2',
        'field_of_activity_3',
        'field_of_activity_4',
        'field_of_activity_5',
        'cadin_estadual',
        'cadin_federal',
        'cadin_checked_at',
    ];
    protected $hidden = [
    ];
    protected $casts = [
        'cadin_checked_at' => 'date',
    ];

    // Situações do CADIN: valor => [rótulo, [fundo, texto]] (cores para <x-table.badge>)
    public const CADIN_STATUSES = [
        'em_dia' => ['Em dia', ['#E8F5E9', '#2E7D32']],
        'devedor' => ['Devedor', ['#FFEBEE', '#C62828']],
    ];

    public const STATUSES = ['ativo', 'pendente', 'desativado'];

    public const SECTORS = [
        'agricultura' => 'Agricultura',
        'biotecnologia' => 'Biotecnologia',
        'química' => 'Substâncias e produtos químicos',
        'aeroespacial' => 'Aeroespacial',
        'hardware' => 'Computadores e hardware',
        'construção' => 'Construção',
        'consultoria' => 'Consultoria',
        'produtos de consumo' => 'Produtos de consumo',
        'serviços ao consumidor' => 'Serviços ao consumidor',
        'marketing digital' => 'Marketing digital',
        'educação' => 'Educação',
        'eletrônica' => 'Eletrônica',
        'moda' => 'Moda',
        'serviços financeiros' => 'Serviços financeiros',
        'alimentos e bebidas' => 'Alimentos e bebidas',
        'jogos' => 'Jogos',
        'serviços de saúde' => 'Serviços de saúde',
        'indústria' => 'Indústria',
        'internet/serviços da web' => 'Internet/serviços da web',
        'serviços de TI' => 'Serviços de TI',
        'jurídico' => 'Jurídico',
        'estilo de vida' => 'Estilo de vida',
        'marítimo' => 'Marítimo',
        'marketing/publicidade' => 'Marketing/publicidade',
        'mídias e entretenimento' => 'Mídias e entretenimento',
        'mineração' => 'Mineração',
        'petróleo e gás' => 'Petróleo e gás',
        'política' => 'Política',
        'imóveis' => 'Imóveis',
        'varejo/distribuição' => 'Varejo/distribuição',
        'segurança' => 'Segurança',
        'software' => 'Software',
        'esportes' => 'Esportes',
        'telecomunicações' => 'Telecomunicações',
        'transportes' => 'Transportes',
        'turismo' => 'Turismo',
        'outros' => 'Outros',
    ];

    // Cores [fundo, texto] da etiqueta de situação
    public static function statusColors($status) {
        return match ($status) {
            'ativo' => ['#E8F5E9', '#2E7D32'],
            'pendente' => ['#FFF8E1', '#F57F17'],
            'desativado' => ['#FFEBEE', '#C62828'],
            default => null,
        };
    }

    public static function cadinStatusOptions() {
        return array_map(fn ($status) => $status[0], self::CADIN_STATUSES);
    }

    public static function cadinLabel($value) {
        return self::CADIN_STATUSES[$value][0] ?? null;
    }

    public static function cadinColors($value) {
        return self::CADIN_STATUSES[$value][1] ?? null;
    }

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

        /**
     * Retorna um array id => name das empresas da conta autenticada, para uso em selects.
     */
    public static function companiesSelectOptions() {
        return self::where('account_id', auth()->user()->account_id)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id')
            ->toArray();
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
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                    foreach (['cadin_estadual', 'cadin_federal'] as $cadinField) {
                        if ($request->$cadinField == 'nao_consultado') {
                            $query->whereNull($cadinField);
                        } elseif ($request->$cadinField) {
                            $query->where($cadinField, $request->$cadinField);
                        }
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

        $items->withQueryString();

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
    public static function registerCustomerDefaultCompany($account, $defaultCompany) {
        
            $customerDefaultCompany = new Company();
            $customerDefaultCompany->account_id = $account->id;
            $customerDefaultCompany->type = 'fornecedor';
            $customerDefaultCompany->name = $defaultCompany['name'];
            $customerDefaultCompany->email = $defaultCompany['email'];
            $customerDefaultCompany->save();
        
        return $customerDefaultCompany;
    }

}
