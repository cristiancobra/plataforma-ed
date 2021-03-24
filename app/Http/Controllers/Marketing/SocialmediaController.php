<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Socialmedia;
use Illuminate\Http\Request;

class SocialmediaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$accounts = userAccounts();

		$socialmedias = Socialmedia::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$total = $socialmedias->total();

		return view('marketing.socialmedia.index', compact(
						'accounts',
						'socialmedias',
						'total'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$socialmedia = new Socialmedia;
		
		$accounts = Account::whereIn('id', userAccounts())
				->get();

		return view('marketing.socialmedia.create', compact(
						'accounts',
						'socialmedia',
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Socialmedia  $socialmedia
	 * @return \Illuminate\Http\Response
	 */
	public function show(Socialmedia $socialmedia) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Socialmedia  $socialmedia
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Socialmedia $socialmedia) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Socialmedia  $socialmedia
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Socialmedia $socialmedia) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Socialmedia  $socialmedia
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Socialmedia $socialmedia) {
		//
	}

}
