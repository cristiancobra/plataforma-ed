<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    
      protected $table = 'shops';
    protected $fillable = [
        'id',
        'account_id',
        'banner_id',
        'headline',
        'name',
        'template',
        'status',
    ];
    protected $hidden = [
    ];

    
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function banner() {
        return $this->hasOne(Image::class, 'id', 'banner_id');
    }

    public function biography() {
        return $this->hasOne(Text::class, 'id', 'biography_id');
    }

    public function logo() {
        return $this->hasOne(Image::class, 'id', 'logo_id');
    }
    
// MÉTODOS PÚBLICOS
    
    public static function returnStatus() {
        return [
            'ativada',
            'desativada',
        ];
    }
}
