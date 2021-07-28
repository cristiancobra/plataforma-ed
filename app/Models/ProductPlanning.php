<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPlanning extends Model {

	protected $table = 'products_plannings';
	protected $fillable = [
		'id',
		'account_id',
		'opportunity_id',
		'invoice_id',
		'amount',
		'subtotal_hours',
		'subtotal_cost',
		'subtotal_tax_rate',
		'subtotal_price',
		'subtotal_margin',
	];
	protected $hidden = [
	];
	
	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function product() {
		return $this->hasOne(Product::class, 'id', 'product_id');
	}


}
