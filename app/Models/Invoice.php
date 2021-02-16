<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $table = 'invoices';
	protected $fillable = [
		'id',
		'account_id',
		'user_id',
		'opportunity_id',
		'company_id',
		'contact_id',
		'description',
		'date_creation',
		'pay_day',
		'discount',
		'subtotal',
		'totalHours',
		'totalAmount',
		'totalCost',
		'totalTax_rate',
		'totalPrice',
		'totalMargin',
		'totalBalance',
		'receipt',
		'type',
		'status',
		'category',
		'receipt',
		'payment_method',
		'number_installment',
		'installment_value',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function company() {
		return $this->belongsTo(Company::class, 'company_id', 'id');
	}

	public function contract() {
		return $this->belongsTo(Contract::class);
	}

	public function invoiceLines() {
		return $this->hasMany(InvoiceLine::class, 'invoice_id', 'id');
	}

	// this is a recommended way to declare event handlers
	public static function boot() {
		parent::boot();
		self::deleting(function($invoice) { // before delete() method call this
			$invoice->invoiceLines()->each(function($invoiceLines) {
				$invoiceLines->delete(); // <-- direct deletion
			});
			// do the rest of the cleanup...
		});
	}

	public function opportunity() {
		return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
