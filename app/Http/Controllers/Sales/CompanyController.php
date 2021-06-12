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
                ->where(function ($query) use ($typeCompanies) {
                    $query->where('type', $typeCompanies)
                    ->orWhere('type', 'cliente e fornecedor');
                })
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $companies->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        $totalCompanies = $companies->count();

        return view('sales.companies.indexCompanies', compact(
                        'typeCompanies',
                        'companies',
                        'totalCompanies',
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

        $businessModelTypes = $this->businessModelTypes();

        return view('sales.companies.createCompany', compact(
                        'typeCompanies',
                        'accounts',
                        'contacts',
                        'states',
                        'businessModelTypes',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $company = new Company();
        $company->fill($request->all());
        $company->save();
        $company->contacts()->sync($request->contacts);
        $typeCompanies = $company->type;

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
        $types = $this->returnTypes();

        $accounts = Account::whereIn('id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $businessModelTypes = $this->businessModelTypes();

        return view('sales.companies.editCompany', compact(
                        'company',
                        'accounts',
                        'states',
                        'typeCompanies',
                        'businessModelTypes',
                        'types'
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
        $company->fill($request->all());
        $company->save();

        $typeCompanies = $request->input('typeCompanies');

        return redirect()->route('company.show', compact(
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

    public function businessModelTypes() {
        $businessModelTypes = [
            'B2B' => ' B2B - Business to Business',
            'B2C' => 'B2C - Business to Consumer',
            'B2E' => 'B2E - Business to Employee',
            'B2P' => 'B2P -  Business to Producer ',
            'B2G' => ' B2P - Business to Government',
            'B2B2C' => 'B2P - Business to Business to Consumer',
            'C2C' => 'B2P - Consumer to Consumer',
            'D2C' => 'B2P - Direct to Consumer ',
        ];
        return $businessModelTypes;
    }

    function returnTypes() {
        return $types = array(
            'concorrente',
            'fornecedor',
            'cliente',
        );
    }

}
