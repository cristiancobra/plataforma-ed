<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Contract extends Model {

	protected $table = 'contracts';
	protected $fillable = [
		'name',
		'account_id',
		'user_id',
		'opportunitie_id',
		'product_id',
		'contact_id',
		'observations',
		'status',
		'witness1',
		'witness2',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}

	public function opportunity() {
		return $this->hasOne(Opportunity::class, 'id', 'opportunitie_id');
	}

	public function products() {
		return $this->hasMany(Product::class, 'contract_product');
	}

//	public function userContact() {
//		return $this->hasOneThrough(Contact::class, User::class, // o model que eu QUERO através do que eu TENHO
//						'contact_id', // Foreign key on the TENHO table...
//						'id', // Foreign key on the QUERO table...
//						'user_id', // Local key on the ESTOU table...
//						'id' // Local key on the TENHO table...
//		);
//	}

}
