<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Product;

class ProductController extends Controller {

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

			$products = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->paginate(20);

			$totalProductss = $products->count();

			return view('sales.products.indexProducts', [
				'products' => $products,
				'totalProductss' => $totalProductss,
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
			$product = new Product();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('sales.products.createProduct', [
				'userAuth' => $userAuth,
				'product' => $product,
				'accounts' => $accounts,
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
		Product::create($request->all());

		return redirect()->action('Sales\\ProductController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product) {
		$userAuth = Auth::user();

		return view('sales.products.showProduct', [
			'product' => $product,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Product $product) {
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

//			$contacts = Contact::whereHas('account', function($query) use($accountsID) {
//						$query->whereIn('account_id', $accountsID);
//					})
//					->orderBy('NAME', 'ASC')
//					->get();
//
//			$tasks = Task::whereHas('account', function($query) use($accountsID) {
//						$query->whereIn('account_id', $accountsID);
//					})
//					->with('contact')
//					->paginate(20);
//
//			$users = User::whereHas('accounts', function($query) use($accountsID) {
//						$query->whereIn('account_id', $accountsID);
//					})
//					->get();

			return view('sales.products.editProduct', [
				'userAuth' => $userAuth,
//				'users' => $users,
				'product' => $product,
//				'tasks' => $tasks,
				'accounts' => $accounts,
//				'contacts' => $contacts,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Product $product) {
		$userAuth = Auth::user();

		$product->fill($request->all());
		$product->save();

		return view('sales.products.showProduct', [
			'product' => $product,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Product $product) {
		$product->delete();
		return redirect()->action('Sales\\ProductController@index');
	}
}
