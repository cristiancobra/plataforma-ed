<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

    protected $table = 'pages';
    protected $fillable = [
        'id',
        'account_id',
        'logo_id',
        'name',
        'url',
        'slug',
        'template',
        'navbar',
        'banner_image_id',
        'headline',
        'text1',
        'text2',
        'principal_color',
        'complementary_color',
        'opposite_color',
        'shop',
        'contact_first_name',
        'contact_last_name',
        'contact_email',
        'contact_phone',
        'contact_site',
        'contact_address',
        'contact_neighborhood',
        'contact_city',
        'contact_state',
        'contact_country',
        'contact_job_position',
        'contact_date_birth',
        'contact_acess_profile',
        'contact_profession',
        'contact_religion',
        'contact_etinicity',
        'contact_naturality',
        'contact_gender',
        'contact_schollarity',
        'contact_civil_state',
        'contact_kids',
        'contact_hobbie',
        'contact_instagram',
        'contact_facebook',
        'contact_linkedin',
        'contact_twitter',
        'contact_lead_source',
        'contact_type',
        'contact_upload_image',
        'company_name',
        'company_income',
        'company_site',
        'company_phone',
        'company_cnpj',
        'company_type',
        'company_about',
        'company_strengths',
        'form',
        'authorization_data',
        'authorization_contact',
        'authorization_newsletter',
        'text_value_offer',
        'biography_id',
        'trash',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function banner() {
        return $this->hasOne(Image::class, 'id', 'banner_image_id');
    }

    public function logo() {
        return $this->hasOne(Image::class, 'id', 'logo_id');
    }

    public function biography() {
        return $this->hasOne(Text::class, 'id', 'biography_id');
    }

    public function contacts() {
//        return $this->hasMany(Contact::class, 'contacts_pages', 'page_id', 'id');
        return $this->belongsToMany(Contact::class, 'contacts_pages')->withTimestamps();
    }

// MÉTODOS PÚBLICOS

    public static function listTemplates() {
        return [
            'funnel_fast' => 'Funil de Vendas Rápido: funil de vendas com formulário de captação',
            'funnel_custom' => 'Funil de Vendas Personalizado: funil de vendas com personalização',
        ];
    }

    public static function returnTemplateName($template) {
        switch ($template) {
            case('funnel_fast');
                return 'Funil de Vendas Rápido: funil de vendas com formulário de captação';
                break;
            case('funnel_custom');
                return 'Home Rápida: Modelo para página inicial com formulário de captação';
                break;
        }
    }

    public static function returnStatus() {
        return [
            'ativada',
            'desativada',
        ];
    }

    public static function formFields() {
        return [
            [
                'name' => 'contact_first_name',
                'label' => 'Primeiro nome'
            ],
            [
                'name' => 'contact_last_name',
                'label' => 'Sobrenome'
            ],
            [
                'name' => 'contact_email',
                'label' => 'Email'
            ],
            [
                'name' => 'contact_phone',
                'label' => 'Telefone'
            ],
            [
                'name' => 'contact_site',
                'label' => 'Site'
            ],
            [
                'name' => 'contact_address',
                'label' => 'Endereço'
            ],
            [
                'name' => 'contact_neighborhood',
                'label' => 'Bairro'
            ],
            [
                'name' => 'contact_city',
                'label' => 'Cidade'
            ],
            [
                'name' => 'contact_state',
                'label' => 'Estado'
            ],
            [
                'name' => 'contact_country',
                'label' => 'País'
            ],
            [
                'name' => 'contact_upload_image',
                'label' => 'Permitir envio de imagem'
            ],
        ];
    }

    public static function formFieldsEdit($page) {
        $formFields = [];
        $counter = 1;
//dd($page->getAttributes());
        foreach ($page->getAttributes() as $name => $value) {
            switch ($name) {
                case('contact_first_name'):
                    $label = 'Primeiro nome';
                    break;
                case('contact_last_name'):
                    $label = 'Sobrenome';
                    break;
                case('contact_email'):
                    $label = 'Email';
                    break;
                case('contact_phone'):
                    $label = 'Telefone';
                    break;
                case('contact_site'):
                    $label = 'Site';
                    break;
                case('contact_address'):
                    $label = 'Endereço';
                    break;
                case('contact_neighborhood'):
                    $label = 'Bairro';
                    break;
                case('contact_city'):
                    $label = 'Cidade';
                    break;
                case('contact_state'):
                    $label = 'Estado';
                    break;
                case('contact_country'):
                    $label = 'País';
                    break;
                case('contact_upload_image'):
                    $label = 'Permitir envio de imagem';
                    break;
                default:
                    $label = null;
                    break;
            }

            if ($label != null) {
                $formFields[$counter]['label'] = $label;
                $formFields[$counter]['name'] = $name;
                $formFields[$counter]['value'] = $value;
                $counter++;
            }
        }
//        dd($formFields);
        return $formFields;
    }

    public static function allowedDomains() {
        return [
            'tudovegano.com.br',
            'rafaelavivianisemijoias.com.br',
            'plataforma.atlassanca.eco.br',
        ];
    }

}
