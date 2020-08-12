<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

// Nome da conexao e da tabela existente
	protected $connection = 'akaunting';
	protected $table = 'transactions';
//  The primary key associated with the table.
	protected $primaryKey = 'id';
//  Indicates if the IDs are auto-incrementing.
	public $incrementing = false;
	public $timestamps = false;

	/**
	 * Transações financeiras do Akaunting, campos disponiveis (mass assignable)
	 */
	protected $fillable = [
		'id', 'company_id', 'type', 'paid_at', 'amount', 'account_id', 'document_id', 'category_id', 'description', 'payment_method', 'deleted_at', 'contact_id'
	];

	/**
	 * Tarefas do SuiteCRM, campos NAO disponiveis (mass assignable)
	 */
	protected $hidden = [
	];

	/**
	 * Akaunting copy
	 */
	public function expense_transactions() {
		return $this->transactions()->where('type', 'expense');
	}

	public function income_transactions() {
		return $this->transactions()->where('type', 'income');
	}

	public function getBalanceAttribute() {
		// Opening Balance
		$total = $this->opening_balance;

		// Sum Incomes
		$total += $this->income_transactions->sum('amount');

		// Subtract Expenses
		$total -= $this->expense_transactions->sum('amount');

		return $total;
	}

}
