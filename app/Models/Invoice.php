<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $table = 'invoices';
	protected $fillable = [
		'id', 'account_id', 'opportunitie_id', 'contact_id', 'description', 'date_creation', 'pay_day', 'price', 'status', 'category', 'invoice',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function contact() {
		return $this->hasOneThrough(
						Contact::class,
						Opportunitie::class,
						'contact_id', // Foreign key on Opportunitie table...
						'id', // Foreign key on Contact table...
						'opportunitie_id', // Local key on Invoice table...
						'id', // Local key on Opportunitie table...);
		);
	}

	public function products() {
		return $this->hasManyThrough(
						Product::class,
						Opportunitie::class,
						'product_id', // Foreign key on Opportunitie table...
						'id', // Foreign key on Product table...
						'id', // Local key on Bills table...
						'id', // Local key on Opportunitie table...);
		);
	}

	//		return $this->hasOneThrough('App\Owner', 'App\Car');

	public function opportunitie() {
		return $this->belongsTo(Opportunitie::class, 'opportunitie_id', 'id');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
