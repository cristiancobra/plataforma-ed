<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'type',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contactLists() {
        return $this->belongsToMany(ContactList::class, 'contact_contact_list', 'contact_id', 'contact_list_id');
    }

    public function contracts() {
        return $this->hasMany(Contract::class, 'id', 'contract_id');
    }

    public function companies() {
        return $this->belongsToMany(Company::class);
    }

    public function opportunities() {
        return $this->hasMany(Opportunity::class, 'contact_id', 'id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'id', 'contact_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id', 'contact_id');
    }

//
//	public function users() {
//		return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
//	}
}
