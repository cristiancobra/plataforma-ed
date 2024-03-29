<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProposal extends Model {

	protected $table = 'products_proposals';
	protected $fillable = [
		'id',
		'account_id',
		'opportunity_id',
		'proposal_id',
		'amount',
		'price',
		'subtotalHours',
		'subtotalCost',
		'subtotalTax_rate',
		'subtotalPrice',
		'subtotalMargin',
	];
	protected $hidden = [
	];
	
	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function proposal() {
		return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
	}

	public function opportunity() {
		return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
	}

	public function product() {
		return $this->hasOne(Product::class, 'id', 'product_id');
	}

//	public function proposal() {
//		return $this->hasMany(Proposal::class, 'id', 'proposal_id');
//	}
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
