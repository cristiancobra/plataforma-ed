<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\ContractTemplate;

class ContractTemplateController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $contractsTemplates = ContractTemplate::where('account_id', auth()->user()->account_id)
                ->with(['account',])
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        return view('sales.contractsTemplates.indexContractsTemplates', compact('contractsTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (Auth::check()) {
            $contractTemplate = new ContractTemplate();

            $accountsID = Account::whereHas('users', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    })
                    ->pluck('id');

            $accounts = Account::whereIn('id', $accountsID)
                    ->orderBy('NAME', 'ASC')
                    ->get();

            return view('sales.contractsTemplates.createContractTemplate', compact(
                            'contractTemplate',
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
    public function store(Request $request) {
        $contractTemplate = new ContractTemplate();
        $contractTemplate->fill($request->all());
        $contractTemplate->save();

        return redirect()->action('Sales\\ContractTemplateController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(ContractTemplate $contractTemplate) {
        return view('sales.contractsTemplates.showContractTemplate', compact('contractTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractTemplate $contractTemplate) {
        $accountsId = Account::whereHas('users', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                })
                ->pluck('id');

        $accounts = Account::whereIn('id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('sales.contractsTemplates.editContractTemplate', compact(
                        'contractTemplate',
                        'accounts',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractTemplate $contractTemplate) {
        $contractTemplate->fill($request->all());
        $contractTemplate->save();

        return view('sales.contractsTemplates.showContractTemplate', compact('contractTemplate'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractTemplate  $contractTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractTemplate $contractTemplate) {
        $contractTemplate->delete();
        return redirect()->action('Sales\\ContractTemplateController@index');
    }

}
