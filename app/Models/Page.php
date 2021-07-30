<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

    protected $table = 'pages';
    protected $fillable = [
        'id',
        'account_id',
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
      'ativada'  ,
        'desativada',
    ];
}
}
