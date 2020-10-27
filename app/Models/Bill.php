<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
  protected $table = 'bills';
	protected $fillable = [
		'id', 'account_id', 'opportunitie_id', 'contact_id', 'description', 'date_creation',  'pay_day',  'price', 'status', 'category', 'stage', 'invoice',
	];
	
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
	
	public function contact() {
		return $this->belongsTo(Contact::class,'contact_id', 'id');
	}
	
	public function opportunitie() {
		return $this->belongsTo(Opportunitie::class,'opportunitie_id', 'id');
	}
}