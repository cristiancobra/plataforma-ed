<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Product;

class ProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$products = Product::where(function ($query) use ($request) {
					$query->whereIn('account_id', userAccounts());
					if ($request->name) {
							$query->where('name', 'like', "%$request->name%");
					}
					if ($request->status) {
						$query->where('status', '=', $request->status);
					}
					if ($request->type) {
						$query->where('type', '=', $request->type);
					}
				})
				->orderBy('name', 'DESC')
				->paginate(20);
//dd($invoices);
		$products->appends([
			'status' => $request->status,
			'contact_id' => $request->contact_id,
			'user_id' => $request->user_id,
		]);

		$contacts = Contact::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereIn('id', userAccounts())
				->orderBy('ID', 'ASC')
				->get();

		$users = myUsers();

		$totalProducts = $products->total();
		
		$type = $request->type;

		return view('sales.products.indexProducts', compact(
						'products',
						'contacts',
						'accounts',
						'users',
						'totalProducts',
						'type',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
public function create(Request $request) {
		$accounts = Account::whereIn('id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

//		$companies = Company::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();
//
//		$contacts = Contact::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();
//
//		$opportunities = Opportunity::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();
//
//		$users = User::whereHas('accounts', function($query) {
//					$query->whereIn('account_id', userAccounts());
//				})
//				->get();

		$type = $request->input('type');

		$products = Product::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->where('type', 'LIKE', $type)
				->orderBy('NAME', 'ASC')
				->get();
				
		return view('sales.products.createProduct', compact(
						'accounts',
//						'opportunities',
//						'contacts',
//						'companies',
						'products',
//						'users',
						'type',
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$product = new Product();
		$product->fill($request->all());

		$messages = [
			'unique' => 'Já existe um contato com este :attribute.',
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'name' => 'required:products',
					'price' => 'required:products',
						], $messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {
			$product->save();
			
			$type = $product->type;
			
			return view('sales.products.showProduct', compact(
							'product',
							'type',
			));
	}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product) {

		return view('sales.products.showProduct', compact(
			'product',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Product $product) {
		$accountsId = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
				})
				->pluck('id');

		$accounts = Account::whereHas('users', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		return view('sales.products.editProduct', compact(
						'product',
						'accounts',
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Product $product) {
		$product->fill($request->all());
		$product->save();
//dd($product);
		return view('sales.products.showProduct', [
			'product' => $product,
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
