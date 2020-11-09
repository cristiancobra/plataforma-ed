<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Account extends Model {

	protected $table = 'accounts';
	protected $fillable = [
		'id', 'user_id', 'name', 'email', 'phone', 'site', 'address', 'address _city', 'address _state', 'address _country', 'type', 'employees', 'status', 'cnpj', 'revenues', 'logo',
		'principal_color', 'complementary_color', 'opposite_color',
	];

	public function contacts() {
		return $this->hasMany(Contact::class, 'id', 'account_id');
	}

	public function facebooks() {
		return $this->hasMany(Facebook::class, 'id', 'account_id');
	}
	
	public function instagrams() {
		return $this->hasMany(Instagram::class, 'id', 'account_id');
	}
	
	public function linkedins() {
		return $this->hasMany(Linkedin::class, 'id', 'account_id');
	}
	
	public function twitters() {
		return $this->hasMany(Twitter::class, 'id', 'account_id');
	}
	
	public function pinterests() {
		return $this->hasMany(Pinterest::class, 'id', 'account_id');
	}
	
	public function spotifys() {
		return $this->hasMany(Spotify::class, 'id', 'account_id');
	}
	
	public function youtubes() {
		return $this->hasMany(Youtube::class, 'id', 'account_id');
	}
	
	public function tasks() {
		return $this->hasMany(Task::class, 'id', 'account_id');
	}

	public function users() {
		return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
	}
}
