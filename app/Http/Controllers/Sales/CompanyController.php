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

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->with([
                    'account',
                    'contacts',
                ])
                ->where(function ($query) use ($typeCompanies) {
                    $query->where('type', $typeCompanies)
                    ->orWhere('type', 'cliente e fornecedor');
                })
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $companies->appends([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'account_id' => $request->account_id,
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
        
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $states = returnStates();

        $businessModelTypes = $this->businessModelTypes();

        return view('sales.companies.createCompany', compact(
                        'typeCompanies',
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
        $company->account_id = auth()->user()->account_id;
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
        $states = returnStates();
        $types = $this->returnTypes();

        $businessModelTypes = Account::businessModelTypes();

        return view('sales.companies.editCompany', compact(
                        'company',
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

        $typeCompanies = $company->type;

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
        $typeCompanies = $company->type;
        $company->delete();

        return redirect()->route('company.index', compact(
                                'typeCompanies',
        ));
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
