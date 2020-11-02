<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Contract extends Model
	{
  protected $table = 'contracts';
	protected $fillable = [
		'name', 'account_id', 'opportunitie_id', 'product_id', 'contact_id', 'observations', 'status',' witness1', 'witness2',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
	public function contact() {
		return $this->belongsTo(Contact::class,'contact_id', 'id');
	}
	
	public function products() {
		return $this->hasMany(Product::class,'contract_product');
	}
}