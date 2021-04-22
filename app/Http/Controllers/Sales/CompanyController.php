<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Company;

class CompanyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $typeCompanies = $request->input('typeCompanies');

        $companies = Company::whereIn('account_id', userAccounts())
                ->with([
                    'account',
                ])
                ->where('type', $typeCompanies)
                ->orWhere('type', 'cliente e fornecedor')
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $companies->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'typeCompanies' => $typeCompanies,
        ]);

        $total = $companies->count();

        return view('sales.companies.indexCompanies', compact(
                        'typeCompanies',
                        'companies',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $typeCompanies = $request->input('typeCompanies');

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $states = returnStates();

        return view('sales.companies.createCompany', compact(
                        'typeCompanies',
                        'accounts',
                        'contacts',
                        'states',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $typeCompanies = $request->input('typeCompanies');

        $company = new Company();
        $company->fill($request->all());
        $company->save();
        $company->contacts()->sync($request->contacts);

        return view('sales.companies.showCompany', compact(
                        'company',
                        'typeCompanies',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Request $request) {
        $typeCompanies = $request->input('typeCompanies');

        return view('sales.companies.showCompany', compact(
                        'company',
                        'typeCompanies',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Request $request) {
        $typeCompanies = $request->input('typeCompanies');

        $accountsId = userAccounts();
        $states = returnStates();

        $accounts = Account::whereIn('id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('sales.companies.editCompany', compact(
                        'company',
                        'accounts',
                        'states',
                        'typeCompanies',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company) {
        $typeCompanies = $request->type;
        $company->fill($request->all());
        $company->save();

        return view('sales.companies.showCompany', compact(
                        'company',
                        'typeCompanies',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company) {
        $company->delete();
        return redirect()->action('Sales\\CompanyController@index');
    }

}
