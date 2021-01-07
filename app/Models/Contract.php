<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\User;

class Contract extends Model {

	protected $table = 'contracts';
	protected $fillable = [
		'name',
		'account_id',
		'user_id',
		'opportunitie_id',
		'product_id',
		'contact_id',
		'company_id',
		'observations',
		'status',
		'witness1',
		'witness2',
		'text',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}
	public function company() {
		return $this->hasOne(Company::class, 'id', 'company_id');
	}
	public function opportunity() {
		return $this->hasOne(Opportunity::class, 'id', 'opportunitie_id');
	}
	public function products() {
		return $this->hasMany(Product::class, 'contract_product');
	}
	public function user() {
		return $this->belongsTo(User::class, 'id', 'contact_id');
	}
}
