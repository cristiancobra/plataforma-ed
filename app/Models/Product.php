<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
	protected $fillable = [
		'id',
		'account_id',
		'image_id',
		'name',
		'cnae',
		'description',
		' type',
		'category',
		'work_hours',
		'points',
		'hourly_cost',
		'cost1',
		'cost1_description',
		'cost2',
		'cost2_description',
		'cost3',
		'cost3_description',
		'tax_rate',
		'tax_amount',
		'margin_contribution',
		'margin_rate',
		'price',
		'stock',
		'status',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
	public function contracts() {
		return $this->belongsToMany(Contract::class,'contract_product');
	}
        	
                  public function image() {
		return $this->hasOne(Image::class, 'id', 'image_id');
	}
        
     // MÉTODOS PÚBLICOS
    
// retorna categoria de produtos de receita
    static function returnRevenuesCategories() {
        return $categories = array(
            'serviço',
            'produto físico',
            'produto digital',
        );
    }

// retorna categoria de produtos de despesa
    static function returnExpensesCategories() {
        return $categories = array(
            'prolabore',
            'salário',
            'marketing',
            'contabilidade',
            'jurídico',
            'infraestrutura',
        );
    }
}
