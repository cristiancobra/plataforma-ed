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
        'image_id',
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
        'company_name',
        'company_income',
        'company_site',
        'company_phone',
        'company_cnpj',
        'company_type',
        'authorization_data',
        'authorization_contact',
        'authorization_newsletter',
        'trash',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function logo() {
        return $this->hasOne(Image::class, 'id', 'logo_id');
    }

//
//    public function company() {
//        return $this->belongsTo(Company::class, 'company_id', 'id');
//    }
//
//    public function contact() {
//        return $this->belongsTo(Contact::class, 'contact_id', 'id');
//    }
//
//    public function invoices() {
//        return $this->hasMany(Invoice::class, 'opportunity_id', 'id');
//    }
//
//    public function user() {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }
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

    public static function formFields($page) {
        $formFields = [];
        $counter = 1;

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
                default:
                    $label = 0;
                    break;
            }


echo $label . "<br>";
                $formFields[$counter]['label'] = $label;
                $formFields[$counter]['name'] = $name;
                $formFields[$counter]['value'] = $value;
                $counter++;

        }
        return $formFields;
    }

}
