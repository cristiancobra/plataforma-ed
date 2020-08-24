<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Account;
use App\Models\Email;

class User extends Authenticatable {

	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'default_password', 'id', 'perfil', 'dominio', 'idcrm', 'accounts'
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
		return $this->hasMany(Account::class, 'user_id', 'id');
	}

	public function emails() {
		return $this->hasMany(Models\Email::class, 'user_id', 'id');
	}

	public function tasks() {
		return $this->hasMany(Models\Task::class, 'user_id', 'id');
	}

	public function PegarIdCrm() {
		return $this->hasOne(UserCrm::class, 'id');
	}

	public function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos) {
		$ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
		$mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
		$nu = "0123456789"; // $nu contem os números
		$si = "!@#$%¨&*()_+="; // $si contem os símbolos

		if ($maiusculas) {
			// se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
			$senha = str_shuffle($ma);
		}

		if ($minusculas) {
			// se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
			$senha .= str_shuffle($mi);
		}

		if ($numeros) {
			// se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
			$senha .= str_shuffle($nu);
		}

		if ($simbolos) {
			// se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
			$senha .= str_shuffle($si);
		}

		// retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
		return substr(str_shuffle($senha), 0, $tamanho);
	}

}
