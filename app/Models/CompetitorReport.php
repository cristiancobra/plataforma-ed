<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitorReport extends Model {

	protected $table = 'competitor_reports';
	protected $fillable = [
		'id',
		'account_id',
		'company_id',
		'report_id',
		'employees',
		'revenue',
		'client_number',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}

	public function report() {
		return $this->belongsTo(Report::class, 'id', 'report_id');
	}

	public function company() {
		return $this->belongsTo(Company::class, 'company_id', 'id');
	}

}
