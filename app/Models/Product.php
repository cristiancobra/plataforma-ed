<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
	protected $fillable = [
		'id', 'account_id', 'name', 'description', 'image', ' type', 'category',
		'work_hours', 'hourly_cost', 'cost1', 'cost1_description', 'cost2', 'cost2_description', 'cost3', 'cost3_description', 'tax_rate', 'tax_amount', 'margin_contribution',
		'margin_rate', 'price',
		'due_date', 'status',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
	
	
	
}
