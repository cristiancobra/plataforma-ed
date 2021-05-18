<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

    protected $table = 'images';
    protected $fillable = [
        'id',
        'account_id',
        'name',
        'alt',
        'path',
        'type',
        'status',
        'status'
    ];

//    public function users() {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

}
