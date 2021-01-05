<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\ContractTemplate;


class ContractTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsId = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');

			$contractsTemplates = ContractTemplate::whereIn('account_id', $accountsId)
					->with(['account',])
					->orderBy('NAME', 'ASC')
					->paginate(20);


			return view('sales.contractsTemplates.indexContractsTemplates', compact(
				'contractsTemplates',
				'userAuth',
			));
		} else {
			return redirect('/');
		}
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	$userAuth = Auth::user();

		if (Auth::check()) {
			$contractTemplate = new ContractTemplate();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			return view('sales.contractsTemplates.createContractTemplate', compact(
				'contractTemplate',
				'userAuth',
				'accounts',
			));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(ContractTemplate $contractTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractTemplate $contractTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractTemplate $contractTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractTemplate $contractTemplate)
    {
        //
    }
}
