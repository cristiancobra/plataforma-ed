<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';
    
    protected $fillable = [
        'account_id',
        'user_id',
        'contact_id',
        'name',
        'category',
        'type',
        'title',
        'description',
        'patrimony_number',
        'control_code',
        'brand',
        'model',
        'purchase_date',
        'manufacturing_date',
        'operating_system',
        'video_card',
        'best_ai',
        'password',
        'users',
        'runs_adobe',
        'runs_vrchat',
        'video_url',
        'code_url',
        'image_url',
        'trash',
        'status',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'manufacturing_date' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function locations()
    {
        return $this->hasMany(CollectionLocation::class);
    }

    public function currentLocation()
    {
        return $this->hasOne(CollectionLocation::class)->where('is_current', true)->latest();
    }

    public static function returnCategories()
    {
        return [
            'físico',
            'digital',
        ];
    }

    public static function returnTypes()
    {
        return [
            'computador',
            'notebook',
            'tablet',
            'smartphone',
            'monitor',
            'TV',
            'impressora',
            'scanner',
            'projetor',
            'câmera',
            'óculos VR',
            'lousa digital',
            'teclado',
            'mouse',
            'headset',
            'fone de ouvido',
            'caixa de som',
            'microfone',
            'webcam',
            'HD externo',
            'SSD externo',
            'pendrive',
            'cartão de memória',
            'roteador',
            'switch',
            'modem',
            'no-break',
            'estabilizador',
            'cabo',
            'adaptador',
            'hub USB',
            'mesa digitalizadora',
            'controle',
            'joystick',
            'servidor',
            'rack',
            'software',
            'licença de software',
            'jogo',
            'assinatura',
            'domínio',
            'outro',
        ];
    }

    public static function returnStatus()
    {
        return [
            'available' => 'Disponível',
            'in use' => 'Em Uso',
            'maintenance' => 'Manutenção',
            'discarded' => 'Descartado',
        ];
    }
}
