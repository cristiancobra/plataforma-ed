<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model {

	protected $table = 'invoice_lines';
	protected $fillable = [
		'id', 'account_id', 'opportunitie_id', 'amount', 'subtotalHours', 'subtotalCost', 'subtotalTax_rate', 'subtotalPrice', 'subtotalMargin', 'invoice_id',
	];
	protected $hidden = [
	];
	
	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function invoice() {
		return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
	}

	public function opportunitie() {
		return $this->belongsTo(Opportunitie::class, 'opportunitie_id', 'id');
	}

	public function product() {
		return $this->hasOne(Product::class, 'id', 'product_id');
	}
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
