<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $table = 'invoices';
	protected $fillable = [
		'id',
		'identifier',
		'account_id',
		'user_id',
		'opportunity_id',
		'company_id',
		'contact_id',
		'contract_id',
		'proposal_id',
		'description',
		'date_creation',
		'pay_day',
		'expiration_date',
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
		'number_installment',
		'number_installment_total',
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
	public function contact() {
		return $this->belongsTo(Contact::class);
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

	public function proposal() {
		return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
	}
        
        public function transactions() {
            return $this->hasMany(Transaction::class);
        }

	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
