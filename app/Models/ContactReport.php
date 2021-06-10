<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReport extends Model {

	protected $table = 'contactsReport';
	protected $fillable = [
		'id',
		'account_id',
		'report_id',
		'lead_source',
		'male_13_17',
		'male_18_24',
		'male_25_34',
		'male_35_44',
		'male_45_54',
		'male_55_65',
		'male_65',
		'female_13_17',
		'female_18_24',
		'female_25_34',
		'female_35_44',
		'female_45_54',
		'female_55_65',
		'profession',
		'job_position',
		'school',
		'city',
		'country',
		'civil_status',
		'naturality',
		'kids',
		'hobby',
		'income',
		'religion',
		'eitinicity',
		'gender'
	];

}
