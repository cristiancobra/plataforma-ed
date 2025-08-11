<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AccountReport extends Model {

	protected $table = 'account_reports';
	protected $fillable = [
		'id',
		 'account_id',
		'report_id',
		'cnpj',
		'logo',
		'pallet',
		
	];

	public function account() {
		return $this->belongsTo(Account::class, 'id', 'account_id');
	}
	public function report() {
		return $this->belongsTo(Report::class, 'id', 'report_id');
	}

}
