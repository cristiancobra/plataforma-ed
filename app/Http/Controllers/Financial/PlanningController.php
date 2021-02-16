<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Planning;
use App\Models\Product;
use App\Models\Transaction;

class PlanningController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$accountsId = userAccounts();

		$plannings = Planning::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$totalPlannings = $plannings->count();

		return view('financial.plannings.indexPlannings', compact(
						'plannings',
						'totalPlannings',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$planning = new Planning();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			$names = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$name = "name0001";
			$amount = "amount0001";
			$hours = "hours0001";
			$cost = "cost0001";
			$tax_rate = "tax_rate0001";
			$price = "price0001";
			$margin = "margin0001";

			return view('financial.plannings.createPlanning', [
				'userAuth' => $userAuth,
				'planning' => $planning,
				'accounts' => $accounts,
				'products' => $names,
				'name' => $name,
				'amount' => $amount,
				'hours' => $hours,
				'cost' => $cost,
				'tax_rate' => $tax_rate,
				'price' => $price,
				'margin' => $margin,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$userAuth = Auth::user();

		$planning = new Planning();
		$planning->account_id = ($request->account_id);
		$planning->name = ($request->name);
		$planning->months = ($request->months);
		$planning->expenses = ($request->expenses);
		$planning->status = ($request->status);

		$name = "name0001";
		$amount = "amount0001";
		$hours = "hours0001";
		$cost = "cost0001";
		$tax_rate = "tax_rate0001";
		$price = "price0001";
		$margin = "margin0001";

		$totalAmount = 0;
		$totalHours = 0;
		$totalCost = 0;
		$totalTax_rate = 0;
		$totalPrice = 0;
		$totalMargin = 0;

		while ($request->$name != null) {
			$planning->$name = $request->$name;

			$planning->$amount = $request->$amount;
			$totalAmount = $totalAmount + $request->$amount;

			$planning->$hours = $request->$hours * $request->$amount;
			$totalHours = $totalHours + $planning->$hours;

			$planning->$cost = $request->$cost * $request->$amount;
			$totalCost = $totalCost + $planning->$cost;

			$planning->$tax_rate = $request->$tax_rate * $request->$amount;
			$totalTax_rate = $totalTax_rate + $planning->$tax_rate;

			$planning->$price = $request->$price * $request->$amount;
			$totalPrice = $totalPrice + $planning->$price;

			$planning->$margin = $request->$margin * $request->$amount;
			$totalMargin = $totalMargin + $planning->$margin;

			$name++;
			$amount++;
			$hours++;
			$cost++;
			$tax_rate++;
			$price++;
			$margin++;
		}
		$planning->totalAmount = $totalAmount;
		$planning->totalHours = $totalHours;
		$planning->totalCost = $totalCost;
		$planning->totalTax_rate = $totalTax_rate;
		$planning->totalPrice = $totalPrice;
		$planning->totalMargin = $totalMargin;
		$planning->totalBalance = $totalMargin - $planning->expenses;
		$planning->save();

		return redirect()->action('Financial\\PlanningController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Planning  $planning
	 * @return \Illuminate\Http\Response
	 */
	public function show(Planning $planning) {
		$userAuth = Auth::user();

		$name = "name0001";
		$amount = "amount0001";
		$hours = "hours0001";
		$cost = "cost0001";
		$tax_rate = "tax_rate0001";
		$price = "price0001";
		$margin = "margin0001";

		return view('financial.plannings.showPlanning', [
			'planning' => $planning,
			'userAuth' => $userAuth,
			'name' => $name,
			'amount' => $amount,
			'hours' => $hours,
			'cost' => $cost,
			'tax_rate' => $tax_rate,
			'price' => $price,
			'margin' => $margin,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Planning  $planning
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Planning $planning) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('financial.plannings.editPlanning', [
				'userAuth' => $userAuth,
				'planning' => $planning,
				'accounts' => $accounts,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Planning  $planning
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Planning $planning) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Planning  $planning
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Planning $planning) {
		$planning->delete();
		return redirect()->action('Financial\\PlanningController@index');
	}

}
