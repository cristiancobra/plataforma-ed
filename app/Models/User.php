<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

	use Notifiable;

	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'email', 'password', 'default_password', 'perfil',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	public function accounts() {
		return $this->belongsToMany(Account::class, 'users_accounts', 'user_id', 'account_id');
	}
	public function contact() {
		return $this->belongsTo(Contact::class, 'contact_id', 'id');
	}
	public function emails() {
		return $this->hasMany(Models\Email::class, 'id', 'user_id');
	}
	public function invoices() {
		return $this->hasMany(User::class, 'id', 'user_id');
	}
	public function journeys() {
		return $this->hasMany(Journey::class, 'id', 'user_id');
	}
	public function opportunities() {
		return $this->hasMany(Opportunity::class, 'user_id', 'id');
	}
	public function tasks() {
		return $this->hasMany(Task::class, 'id', 'user_id');
	}
//	public function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos) {
//		$ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
//		$mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
//		$nu = "0123456789"; // $nu contem os números
//		$si = "!@#$%¨&*()_+="; // $si contem os símbolos
//
//		if ($maiusculas) {
//			// se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
//			$senha = str_shuffle($ma);
//		}
//
//		if ($minusculas) {
//			// se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
//			$senha .= str_shuffle($mi);
//		}
//
//		if ($numeros) {
//			// se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
//			$senha .= str_shuffle($nu);
//		}
//
//		if ($simbolos) {
//			// se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
//			$senha .= str_shuffle($si);
//		}
//
//		// retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
//		return substr(str_shuffle($senha), 0, $tamanho);
//	}
}
