<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $table = 'plannings';
	protected $fillable = [
		'id', 'account_id', 'name', 'expenses', 'months',
		
		'name1', ' amount1', 'hours1', 'cost1', 'tax_rate1', 'price1',
		'name2', ' amount2', 'hours2', 'cost2', 'tax_rate2', 'price2',
		'name3', ' amount3', 'hours3', 'cost3', 'tax_rate3', 'price3',
		'name4', ' amount4', 'hours4', 'cost4', 'tax_rate4', 'price4',
		'name5', ' amount5', 'hours5', 'cost5', 'tax_rate5', 'price5',
		'name6', ' amount6', 'hours6', 'cost6', 'tax_rate6', 'price6',
		'name7', ' amount7', 'hours7', 'cost7', 'tax_rate7', 'price7',
		'name8', ' amount8', 'hours8', 'cost8', 'tax_rate8', 'price8',
		'name9', ' amount9', 'hours9', 'cost9', 'tax_rate9', 'price9',
		'name10', ' amount10', 'hours10', 'cost10', 'tax_rate10', 'price10',
		'name11', ' amount11', 'hours11', 'cost11', 'tax_rate11', 'price11',
		'name12', ' amount12', 'hours12', 'cost12', 'tax_rate12', 'price12',
		'name13', ' amount13', 'hours13', 'cost13', 'tax_rate13', 'price13',
		'name14', ' amount14', 'hours14', 'cost14', 'tax_rate14', 'price14',
		'name15', ' amount15', 'hours15', 'cost15', 'tax_rate15', 'price15',
		'name16', ' amount16', 'hours16', 'cost16', 'tax_rate16', 'price16',
		'name17', ' amount17', 'hours17', 'cost17', 'tax_rate17', 'price17',
		'name18', ' amount18', 'hours18', 'cost18', 'tax_rate18', 'price18',
		'name19', ' amount19', 'hours19', 'cost19', 'tax_rate19', 'price19',
		'name20', ' amount20', 'hours20', 'cost20', 'tax_rate20', 'price20',
		
		'status',
		
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
}
