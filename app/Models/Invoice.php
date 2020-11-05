<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $table = 'invoices';
	protected $fillable = [
		'id', 'account_id', 'opportunitie_id', 'contact_id', 'description', 'date_creation', 'pay_day', 'price', 'status', 'category', 'receipt',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function invoiceLines() {
		return $this->hasMany(InvoiceLine::class, 'id', 'invoice_id');
	}

	public function opportunitie() {
		return $this->belongsTo(Opportunitie::class, 'opportunitie_id', 'id');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
