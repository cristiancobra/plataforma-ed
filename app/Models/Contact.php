<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Account;

//use App\User;

class Contact extends Model {

    protected $table = 'contacts';
    protected $fillable = [
        'id',
        'account_id',
        'name',
        'first_name',
        'last_name',
        'cpf',
        'email',
        'phone',
        'site',
        'address',
        'city',
        'state',
        'country',
        'type',
        'company',
        'zip_code',
        'cep',
        'neighborhood',
        'job_position',
        'acess_profile',
        'date_birth',
        'profession',
        'religion',
        'etinicity',
        'naturality',
        'sexual_orientation',
        'schollarity',
        'income',
        'civil_state',
        'kids',
        'hobbie',
        'instagram',
        'facebook',
        'linkedin',
        'twitter',
        'lead_source',
        'authorization_data',
        'authorization_contact',
        'authorization_newsletter',
        'status',
    ];
    protected $hidden = [
    ];

    //RELACIONAMENTOS
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contracts() {
        return $this->hasMany(Contract::class, 'id', 'contract_id');
    }

    public function companies() {
        return $this->belongsToMany(Company::class);
    }

    public function images() {
        return $this->hasMany(Image::class, 'contact_id', 'id');
    }

    public function opportunities() {
        return $this->hasMany(Opportunity::class, 'contact_id', 'id');
    }

    public function pages() {
        return $this->belongsToMany(Page::class, 'contacts_pages');
//        return $this->belongsToMany(Page::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'id', 'contact_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id', 'contact_id');
    }

//FUNÇÕES PÚBLICAS
    public static function filterModel(Request $request) {
        if ($request->filter == 'news') {
            $orderColumn = 'created_at';
            $orderDirection = 'DESC';
        } else {
            $orderColumn = 'name';
            $orderDirection = 'ASC';
        };

        $items = Contact::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->company_id) {
                        $query->whereHas('companies', function ($query) use ($request) {
                            $query->where('company_id', $request->company_id);
                        });
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->created_at) {
                        $query->where('created_at', '>=', $request->created_at);
                    }
                    if ($request->page_id) {
                        $query->whereHas('pages', function ($query) use ($request) {
                            $query->where('page_id', $request->page_id);
                        });
                    }
//                    if ($request->status == '') {
//                        // busca todos
//                    } elseif ($request->status == 'fazendo') {
//                        $query->where('status', 'fazer');
//                        $query->whereHas('journeys');
//                    } elseif ($request->status) {
//                        $query->where('status', $request->status);
//                    }
                })
//                ->with(
//                        'opportunity',
//                        'journeys',
//                        'user.contact',
//                        'user.image',
//                )
                ->orderBy($orderColumn, $orderDirection)
                ->paginate(20);

        $items->appends([
            'name' => $request->name,
            'company' => $request->company_id,
            'type' => $request->type,
        ]);

        return $items;
    }

    public static function returnSources() {
        return [
            '',
            'site',
            'pesquisa paga',
            'pesquisa orgânica',
            'email marketing',
            'indicação',
            'mídia social',
            'outbound',
            'outros'
        ];
    }

    public static function returnGenderTypes() {
        return [
            '',
            'masculino',
            'feminino',
            'não-binário',
        ];
    }

    public static function returnHobbie() {
        return [
            '',
            'artes plásticas e visuais',
            'dança',
            'cinema e séries',
            'comer',
            'cozinhar',
            'esportes',
            'jardinagem',
            'jogos eletrônicos',
            'ler e escrever',
            'línguas',
            'música',
            'teatro',
            'trabalho voluntário',
        ];
    }

    public static function returnReligion() {
        return [
            '',
            'agnóstico',
            'ateu',
            'católico',
            'espírita',
            'matriz africana',
        ];
    }

    public static function returnEtinicity() {
        return [
            '',
            'branco ou caucasiano',
            'amarelo ou mongol',
            'negro',
            'indígina',
            'matriz africana',
        ];
    }

    public static function returnContactTypes() {
        return [
            'cliente',
            'funcionário',
            'fornecedor',
            'parceiro',
        ];
    }

    public static function returnProfessions() {
        return [
            '',
            'Administrador',
            'Administrador público',
            'Advogado',
            'Arqueólogo',
            'Agricultor',
            'Agropecuarista',
            'Animador',
            'Arquiteto',
            'Artes e Design',
            'Artista plástico',
            'Ator',
            'Assistente de compras',
            'Assessor político',
            'Cabeleireiro',
            'Chef',
            'Construtor civil',
            'Construtor naval',
            'Contabilista',
            'Engenheiro acústico',
            'Engenheiro aeronáutico',
            'Engenheiro agrícola',
            'Engenheiro ambiental e sanitário',
            'Engenheiro biomédico',
            'Engenheiro civil',
            'Engenheiro da computação',
            'Engenheiro de alimentos',
            'Engenheiro de biossistemas',
            'Engenheiro de controle e automação',
            'Engenheiro de energia',
            'Engenheiro de inovação',
            'Engenheiro de materiais',
            'Engenheiro de minas',
            'Engenheiro de pesca',
            'Engenheiro de petróleo',
            'Engenheiro de produção',
            'Engenheiro de segurança do trabalho',
            'Engenheiro de sistemas',
            'Engenheiro de software',
            'Engenheiro de telecomunicações',
            'Engenheiro de transporte e mobilidade',
            'Engenheiro elétrico',
            'Engenheiro eletrônico',
            'Engenheiro físico',
            'Engenheiro florestal',
            'Engenheiro hídrico',
            'Engenheiro mecânico',
            'Engenheiro mecatrônico',
            'Engenheiro naval',
            'Engenheiro químico',
            'Secretária executiva',
            'Economista',
            'Especialista em comércio exterior',
            'Gerente comercial',
            'Gestor de recursos humanos',
            'Gestor de turismo',
            'Gestor público',
            'Hoteleiro',
            'Piloto de avião',
            'Dançarino',
            'Designer',
            'Designer de games',
            'Designer de interiores',
            'Designer de moda',
            'Fotógrafo',
            'Historiador da arte',
            'Músico',
            'Produtor cênico',
            'Produtor fonográfico',
            'Programador',
            'Agrônomo',
            'Bioquímico',
            'Biotecnólogo',
            'Ecologista',
            'Geofísico',
            'Geólogo',
            'Gestor ambiental',
            'Veterinário',
            'Meteorologista',
            'Oceanógrafo',
            'Zootecnólogo',
            'Analista e desenvolvedor de sistemas',
            'Astrônomo',
            'Cientista da computação',
            'Estatístico',
            'Físico',
            'Gestor da tecnologia da informação',
            'Matemático',
            'Nanotecnólogo',
            'Químico',
            'Cooperativista',
            'Filósofo',
            'Geógrafo',
            'Historiador',
            'Linguista',
            'Museologista',
            'Pedagogo',
            'Professor',
            'Psicopedagogo',
            'Relações internacionais',
            'Sociólogo',
            'Comunicação e Informação',
            'Arquivologista',
            'Biblioteconomista',
            'Educomunicador',
            'Jornalista',
            'Político',
            'Produtor audiovisual',
            'Produtor cultural',
            'Produtor editorial',
            'Produtor multimídia',
            'Produtor publicitário',
            'Publicitário',
            'Radialista',
            'Relações públicas',
            'Secretária',
            'Gestor da qualidade',
            'Minerador',
            'Silvicultor',
            'Saúde e Bem-Estar',
            'Biomédico',
            'Dentista',
            'Educador físico',
            'Enfermeiro',
            'Esteticista',
            'Farmacêutico',
            'Fisioterapeuta',
            'Fonoaudiólogo',
            'Gerontólogo',
            'Gestor em saúde',
            'Gestor hospitalar',
            'Médico',
            'Musicoterapeuta',
            'Nutricionista',
            'Psicólogo',
            'Radiologista',
            'Técnico administrativo',
            'Teólogo',
            'Tradutor e intérprete',
            'Terapeuta ocupacional',
            'Turismólogo',
            'outro',
        ];
    }

    public static function returnJobPosition() {
        return [
            '',
            'Administrador',
            'Administrador público',
            'Agricultor',
            'Agropecuarista',
            'Arquivologista',
            'Artes e Design',
            'Animador',
            'Arquiteto',
            'Assessor poítico',
            'Artista plástico',
            'Ator',
            'Biblioteconomista',
            'Biomédico',
            'Chef',
            'Contabilista',
            'Economista',
            'Especialista em comércio exterior',
            'Gerente comercial',
            'Gestor de recursos humanos',
            'Gestor de turismo',
            'Gestor público',
            'Hoteleiro',
            'Piloto de avião',
            'Dançarino',
            'Designer',
            'Designer de games',
            'Designer de interiores',
            'Designer de moda',
            'Fotógrafo',
            'Historiador da arte',
            'Músico',
            'Produtor cênico',
            'Produtor fonográfico',
            'Agrônomo',
            'Bioquímico',
            'Biotecnólogo',
            'Ecologista',
            'Geofísico',
            'Geólogo',
            'Gestor ambiental',
            'Veterinário',
            'Meteorologista',
            'Oceanógrafo',
            'Analista e desenvolvedor de sistemas',
            'Astrônomo',
            'Cientista da computação',
            'Estatístico',
            'Físico',
            'Gestor da tecnologia da informação',
            'Matemático',
            'Nanotecnólogo',
            'Químico',
            'Advogado',
            'Arqueólogo',
            'Cooperativista',
            'Filósofo',
            'Geógrafo',
            'Historiador',
            'Linguista',
            'Museologista',
            'Pedagogo',
            'Professor',
            'Psicopedagogo',
            'Relações internacionais',
            'Sociólogo',
            'Teólogo',
            'Tradutor e intérprete',
            'Comunicação e Informação',
            'Educomunicador',
            'Jornalista',
            'Político',
            'Produtor audiovisual',
            'Produtor cultural',
            'Produtor editorial',
            'Produtor multimídia',
            'Produtor publicitário',
            'Publicitário',
            'Radialista',
            'Relações públicas',
            'Secretária',
            'Secretária executiva',
            'Construtor civil',
            'Construtor naval',
            'Engenheiro acústico',
            'Engenheiro aeronáutico',
            'Engenheiro agrícola',
            'Engenheiro ambiental e sanitário',
            'Engenheiro biomédico',
            'Engenheiro civil',
            'Engenheiro da computação',
            'Engenheiro de alimentos',
            'Engenheiro de biossistemas',
            'Engenheiro de controle e automação',
            'Engenheiro de energia',
            'Engenheiro de inovação',
            'Engenheiro de materiais',
            'Engenheiro de minas',
            'Engenheiro de pesca',
            'Engenheiro de petróleo',
            'Engenheiro de produção',
            'Engenheiro de segurança do trabalho',
            'Engenheiro de sistemas',
            'Engenheiro de software',
            'Engenheiro de telecomunicações',
            'Engenheiro de transporte e mobilidade',
            'Engenheiro elétrico',
            'Engenheiro eletrônico',
            'Engenheiro físico',
            'Engenheiro florestal',
            'Engenheiro hídrico',
            'Engenheiro mecânico',
            'Engenheiro mecatrônico',
            'Engenheiro naval',
            'Engenheiro químico',
            'Escrevente',
            'Gestor da qualidade',
            'Minerador',
            'Silvicultor',
            'Saúde e Bem-Estar',
            'Dentista',
            'Educador físico',
            'Enfermeiro',
            'Esteticista',
            'Farmacêutico',
            'Fisioterapeuta',
            'Fonoaudiólogo',
            'Gerontólogo',
            'Gestor em saúde',
            'Gestor hospitalar',
            'Médico',
            'Musicoterapeuta',
            'Nutricionista',
            'Psicólogo',
            'Radiologista',
            'Terapeuta ocupacional',
            'Turismólogo',
            'Zootecnólogo',
            'outro',
        ];
    }

    public static function returnStates() {
        return $states = array(
            '' => '',
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espirito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MS' => 'Mato Grosso do Sul',
            'MT' => 'Mato Grosso',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        );
    }

    public static function returnStatus() {
        return [
            'ativo',
            'desativado',
            'pendente',
            'descadastrado',
        ];
    }

    public static function totalAndPercentage($field, array $items) {
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'cliente')
                ->get();

        $totalContacts = $contacts->count();
        $totalPercentual = 0;

        foreach ($items as $item) {
            $totalItem = $contacts->where($field, $item)->count();

            if ($totalItem > 0) {
                if ($totalItem > 0) {
                    $percentualItem = percentage($totalItem, $totalContacts);
                } else {
                    $percentualItem = 0;
                }

                if ($item == null) {
                    $item = 'Não sei';
                }

                $itemsTotals[$item] = [
                    'name' => $item,
                    'total' => $totalItem,
                    'percentual' => $percentualItem,
                ];
            }
        }
        if (isset($itemsTotals)) {
            // coloca na ordem do maior para o menor
            usort($itemsTotals, function ($a, $b) {
                return $b['total'] <=> $a['total'];
            });
            return $itemsTotals;
        } else {
            return [];
        }
    }

    public static function totalAndPercentageWon($field, array $items) {
        $contacts = Contact::whereHas('opportunities', function ($query) {
                    $query->where('account_id', auth()->user()->account_id);
                    $query->where('status', 'ganhamos');
                })
                ->get();

        $totalContacts = $contacts->count();
        $totalPercentual = 0;

        foreach ($items as $item) {
            $totalItem = $contacts->where($field, $item)->count();

            if ($totalItem > 0) {
                if ($totalItem > 0) {
                    $percentualItem = percentage($totalItem, $totalContacts);
                } else {
                    $percentualItem = 0;
                }

                if ($item == null) {
                    $item = 'Não sei';
                }

                $itemsTotals[$item] = [
                    'name' => $item,
                    'total' => $totalItem,
                    'percentual' => $percentualItem,
                ];
            }
        }

        if (isset($itemsTotals)) {
            // coloca na ordem do maior para o menor
            usort($itemsTotals, function ($a, $b) {
                return $b['total'] <=> $a['total'];
            });
            return $itemsTotals;
        } else {
            return [];
        }
    }

    public static function countSuspects() {
        return Contact::where('account_id', auth()->user()->account_id)
                        ->where('type', 'cliente')
                        ->where('points', '<', 50)
                        ->count();
    }

    public static function countProspects() {
        return Contact::where('account_id', auth()->user()->account_id)
                        ->where('type', 'cliente')
                        ->whereBetween('points', [50, 99])
                        ->count();
    }

    public static function countQualified() {
        return Contact::where('account_id', auth()->user()->account_id)
                        ->where('type', 'cliente')
                        ->where('points', '>=', 100)
                        ->count();
    }

    public static function countNewsContactsWeek() {
        $lastWeek = date("Y-m-d", strtotime("-7 days"));

        return Contact::where('account_id', auth()->user()->account_id)
                        ->where('type', 'cliente')
                        ->where('created_at', '>=', $lastWeek)
                        ->count();
    }

    public static function getNewsContactsWeek() {
        $lastWeek = date("Y-m-d", strtotime("-30 days"));

        return Contact::where('account_id', auth()->user()->account_id)
                        ->where('type', 'cliente')
                        ->where('created_at', '>=', $lastWeek)
                        ->get();
    }

    /**
     * checa se existe contato cadastrado
     * @return type
     */
    public static function existingContact($account, $email) {
        $contact = Contact::where('email', $email)
                ->where('account_id', $account)
                ->first();
        
        if($contact == null) {
            return false;
        }else{
            return $contact;
        }

     
    }

}
