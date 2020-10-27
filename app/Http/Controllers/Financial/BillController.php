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
//						'products',
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

			return view('financial.bills.createBill', [
				'userAuth' => $userAuth,
				'bill' => $bill,
				'accounts' => $accounts,
				'opportunities' => $opportunities,
				'contacts' => $contacts,
				'products' => $products,
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
		$bill = new Bill;
		$bill->opportunitie_id = $request->opportunitie_id;
		$opportunitie = Opportunitie::find($bill->opportunitie_id)->with('account','contact')->first();
		$bill->account_id = $opportunitie->account->id;
		$opportunitie2 = Opportunitie::find($bill->opportunitie_id)->with('contact')->first();
		$bill->contact_id = $opportunitie2->contact->id;
		$bill->date_creation = $request->date_creation;
		$bill->pay_day = $request->pay_day;
		$bill->description = $request->description;
		$bill->status = $request->status;
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

		return view('financial.bills.showBill', [
			'bill' => $bill,
			'userAuth' => $userAuth,
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
