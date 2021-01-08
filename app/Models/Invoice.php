<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $table = 'invoices';
	protected $fillable = [
		'id',
		'account_id',
		'opportunity_id',
		'contact_id',
		'description',
		'date_creation',
		'pay_day',
		'price',
		'status',
		'category',
		'receipt',
		'payment_method',
		'number_installments',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function invoiceLines() {
		return $this->hasMany(InvoiceLine::class, 'id', 'invoice_id');
	}

	public function opportunity() {
		return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
