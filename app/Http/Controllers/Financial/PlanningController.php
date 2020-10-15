<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Planning;
use App\Models\Product;
use Illuminate\Http\Request;

class PlanningController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');

			$plannings = Planning::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->paginate(20);

			$totalPlannings = $plannings->count();

			return view('financial.plannings.indexPlannings', [
				'plannings' => $plannings,
				'totalPlannings' => $totalPlannings,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
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
		while ($request->$name != null) {
			$planning->$name = $request->$name;
			$name++;
		}

		$amount = "amount0001";
		while ($request->$amount != null) {
			$planning->$amount = $request->$amount;
			$amount++;
		}

		$hours = "hours0001";
		while ($request->$hours != null) {
			$planning->$hours = $request->$hours;
			$hours++;
		}

		$cost = "cost0001";
		while ($request->$cost != null) {
			$planning->$cost = $request->$cost;
			$cost++;
		}

		$tax_rate = "tax_rate0001";
		while ($request->$tax_rate != null) {
			$planning->$tax_rate = $request->$tax_rate;
			$tax_rate++;
		}

		$price = "price0001";
		while ($request->$price != null) {
			$planning->$price = $request->$price;
			$price++;
		}

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

		return view('financial.plannings.showPlanning', [
			'planning' => $planning,
			'userAuth' => $userAuth,
			'name' => $name,
			'amount' => $amount,
			'hours' => $hours,
			'cost' => $cost,
			'tax_rate' => $tax_rate,
			'price' => $price,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Planning  $planning
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Planning $planning) {
		//
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
