<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'default_password',
        'perfil',
        'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
//    RELACIONAMENTOS
    public function account() {
        return $this->belongsTo(Account::class,'id', 'account_id');
    }

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function emails() {
        return $this->hasMany(Models\Email::class, 'id', 'user_id');
    }

    public function invoices() {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function journeys() {
        return $this->hasMany(Journey::class, 'id', 'user_id');
    }

    public function opportunities() {
        return $this->hasMany(Opportunity::class, 'user_id', 'id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'id', 'user_id');
    }

//MÉTODOS PÚBLICO
    
    public static function myUsers() {
        return $users = User::where('account_id', auth()->user()->account_id)
//                ->join('contacts', 'contacts.id', '=', 'users.contact_id')
//                ->orderBy('NAME', 'ASC')
                ->get();
    }
}
