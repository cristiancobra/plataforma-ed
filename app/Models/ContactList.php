<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\Models\Contact;

class ContactList extends Model {

    protected $table = 'contact_list';
    protected $fillable = [
        'name',
        'account_id',
        'created_in',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contacts() {
        return $this->hasMany(Contact::class, 'contact_contact_list');
    }

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

}
