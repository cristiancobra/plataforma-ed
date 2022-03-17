<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomerResetPassword;
use DateTime;
use DateInterval;

class User extends Authenticatable implements MustVerifyEmail {

    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'image_id',
        'email',
        'password',
        'default_password',
        'perfil',
        'created_at',
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
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function emails() {
        return $this->hasMany(Models\Email::class, 'id', 'user_id');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
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
//                ->join('images', 'images.id', '=', 'users.image_id')
//                ->select(
//                        'users.id as id',
//                        'contacts.name as name',
//                        'images.path as image',
//                )
                ->with([
                    'image',
                    'contact',
                ])
//                ->orderBy('NAME', 'ASC')
                ->get();
    }

    // EMPRESA DIGITAL:  cria USUÁRIO com o contato fornecido quando uma nova conta é registrada
    public static function registerUser($request, $contactId, $accountId) {
        $user = new User();
        $user->contact_id = $contactId;
        $user->perfil = 'dono';
        $user->email = $request->email;
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->account_id = $accountId;
        $today = new Datetime('now');
        $today->add(new DateInterval('P1M'));
        $user->save();

        return $user;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new CustomerResetPassword($token));
    }

    /**
     * Function that returns user profiles.
     * Função que retorna os perfis de usuários.
     * 
     * @access public
     * @param object $user
     * @return array $roles
     */
    public static function getRoles($user) {
        if ($user == 'super administrador') {
            $roles = [
                'funcionário',
                'administrador',
                'dono',
                'super administrador',
            ];
        } elseif($user == 'dono') {
            $roles = [
                'funcionário',
                'administrador',
                'dono',
            ];
        } elseif($user == 'administrador') {
            $roles = [
                'funcionário',
                'administrador',
            ];
        } elseif($user == 'funcionário') {
            $roles = [
                'funcionário',
            ];
        }
        return $roles;
    }

}
