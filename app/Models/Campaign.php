<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Campaign extends Model {

    protected $table = 'campaigns';
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'email_id',
        'name',
        'send_date',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function email() {
        return $this->hasOne(Email::class, 'id', 'email_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
