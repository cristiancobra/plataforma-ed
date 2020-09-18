<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\User;

class Competitor extends Model
{
protected $table = 'competitors';
	protected $fillable = [
		'id', 'account_id', 'name', 'description', 'site', 'city', 'state', 'country', 'type',
		'facebook_followers',
		'instagram_followers',
		'linkedin_followers',
		'twitter_followers',
		'pinterest_followers',
		'youtube_followers',
		'google_business', 'google_business_score', 'google_business_comments',
		 'ifood', 'ifood_score', 'ifood_comments',
		'spotfy',
	];
	protected $hidden = [
	];

	public function account() {
		return $this->belongsTo(Account::class, 'account_id', 'id');
	}
}

