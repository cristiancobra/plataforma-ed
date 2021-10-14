<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Account extends Model {

	protected $table = 'accounts';
	protected $fillable = [
		'id',
		'user_id',
		'image_id',
		'name',
		'email',
		'phone',
		'site',
		'address',
		'city',
		'state',
		'country',
		'zip_code',
		'type',
		'employees',
		'status',
		'cnpj', 
		'logo',
		'principal_color',
		'complementary_color',
		'opposite_color',
		'business_model',
		'competitive_advantage',
		'revenues',
		'sector',
		'value_offer',
		'status',
	];

        
        // RELACIONAMENTOS
	public function bankAccounts() {
		return $this->hasMany(BankAccount::class, 'id', 'account_id');
	}
	public function contacts() {
		return $this->hasMany(Contact::class, 'id', 'account_id');
	}
                public function image() {
                        return $this->hasOne(Image::class, 'id', 'image_id');
                }
	public function emails() {
		return $this->hasMany(Email::class, 'id', 'account_id');
	}
	public function facebooks() {
		return $this->hasMany(Facebook::class, 'id', 'account_id');
	}
	public function instagrams() {
		return $this->hasMany(Instagram::class, 'id', 'account_id');
	}
	public function journeys() {
		return $this->hasMany(Journey::class, 'id', 'user_id');
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
		return $this->hasMany(User::class, 'account_id', 'id');
	}

    // MÉTODOS PÚBLICOS

    public static function businessModelTypes() {
        $businessModelTypes = [
            'B2B' => ' B2B - Business to Business',
            'B2C' => 'B2C - Business to Consumer',
            'B2E' => 'B2E - Business to Employee',
            'B2P' => 'B2P -  Business to Producer ',
            'B2G' => ' B2P - Business to Government',
            'B2B2C' => 'B2P - Business to Business to Consumer',
            'C2C' => 'B2P - Consumer to Consumer',
            'D2C' => 'B2P - Direct to Consumer ',
        ];
        return $businessModelTypes;
    }
    
            public static function returnStatus() {
            return $status = [
                'ativa',
                'desativada',
            ];
        }

}