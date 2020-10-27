<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunitie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller {

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

			$bills = Bill::whereIn('account_id', $accountsID)
					->with([
						'contact',
						'account',
						'products',
					])
					->orderBy('pay_day', 'DESC')
					->paginate(20);

			$totalBills = $bills->count();

			return view('financial.bills.indexBills', [
				'bills' => $bills,
				'totalBills' => $totalBills,
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
			$bill = new Bill();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$opportunities = Opportunitie::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$products = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$name = "name0001";
			$amount = "amount0001";
			$hours = "hours0001";
			$cost = "cost0001";
			$tax_rate = "tax_rate0001";
			$price = "price0001";
			$margin = "margin0001";

			return view('financial.bills.createBill', [
				'userAuth' => $userAuth,
				'bill' => $bill,
				'accounts' => $accounts,
				'opportunities' => $opportunities,
				'contacts' => $contacts,
				'products' => $products,
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
		$bill = new Bill();
				
		$bill->opportunitie_id = $request->opportunitie_id;
		$opportunitie = Opportunitie::find($bill->opportunitie_id)->with('account')->first();
		$bill->account_id = $opportunitie->account->id;
//		$opportunitie2 = Opportunitie::find($bill->opportunitie_id)->with('contact')->first();
//		$bill->contact_id = $opportunitie2->contact->id;
		$bill->date_creation = $request->date_creation;
		$bill->pay_day = $request->pay_day;
		$bill->description = $request->description;
		$bill->status = $request->status;
		
//		$bill->contact_id = ($request->contact_id);

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
			$bill->$name = $request->$name;

			$bill->$amount = $request->$amount;
			$totalAmount = $totalAmount + $request->$amount;

			$bill->$hours = $request->$hours * $request->$amount;
			$totalHours = $totalHours + $bill->$hours;

			$bill->$cost = $request->$cost * $request->$amount;
			$totalCost = $totalCost + $bill->$cost;

			$bill->$tax_rate = $request->$tax_rate * $request->$amount;
			$totalTax_rate = $totalTax_rate + $bill->$tax_rate;

			$bill->$price = $request->$price * $request->$amount;
			$totalPrice = $totalPrice + $bill->$price;

			$bill->$margin = $request->$margin * $request->$amount;
			$totalMargin = $totalMargin + $bill->$margin;

			$name++;
			$amount++;
			$hours++;
			$cost++;
			$tax_rate++;
			$price++;
			$margin++;
		}
		$bill->totalAmount = $totalAmount;
		$bill->totalHours = $totalHours;
		$bill->totalCost = $totalCost;
		$bill->totalTax_rate = $totalTax_rate;
		$bill->totalPrice = $totalPrice;
		$bill->totalMargin = $totalMargin;
		$bill->totalBalance = $totalMargin - $bill->expenses;

		$bill->save();

		return redirect()->action('Financial\\BillController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function show(Bill $bill) {
		$userAuth = Auth::user();
		$name = "name0001";
		$amount = "amount0001";
		$hours = "hours0001";
		$cost = "cost0001";
		$tax_rate = "tax_rate0001";
		$price = "price0001";
		$margin = "margin0001";
		
		return view('financial.bills.showBill', [
			'bill' => $bill,
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
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Bill $bill) {
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

			$opportunities = Opportunitie::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			return view('financial.bills.editBill', [
				'userAuth' => $userAuth,
				'bill' => $bill,
				'accounts' => $accounts,
				'opportunities' => $opportunities,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Bill $bill) {
		$userAuth = Auth::user();

		$bill->fill($request->all());
		$bill->push();

		return view('financial.bills.showBill', [
			'bill' => $bill,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Bill $bill) { {
			$bill->delete();
			return redirect()->action('Financial\\BillController@index');
		}
	}

}
