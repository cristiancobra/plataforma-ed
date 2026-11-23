<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Company;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $typeCompanies = $request->input('typeCompanies', $request->input('type'));
        $request->merge(['type' => $typeCompanies]);

        $companies = Company::filterModel($request);
        $total = $companies->total();

        $accountCompanies = Company::where('account_id', auth()->user()->account_id)
            ->where('type', $typeCompanies);

        $totalTotal = (clone $accountCompanies)->count();
        $filtersActive = collect($request->except(['page', 'trash', 'role', 'type', 'typeCompanies']))
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->isNotEmpty();

        $distinct = fn ($column) => (clone $accountCompanies)
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->orderBy($column)
            ->distinct()
            ->pluck($column)
            ->toArray();

        $cities = $distinct('city');
        $states = $distinct('state');
        $countries = $distinct('country');
        $statuses = Company::STATUSES;
        $cadinOptions = Company::cadinStatusOptions() + ['nao_consultado' => 'Não consultado'];

        return view('sales.companies.indexCompanies', compact(
            'typeCompanies',
            'companies',
            'total',
            'totalTotal',
            'filtersActive',
            'cities',
            'states',
            'countries',
            'statuses',
            'cadinOptions',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $typeCompanies = $request->input('typeCompanies');
        $company = new Company(['type' => $typeCompanies, 'status' => 'ativo']);

        return view('sales.companies.createCompany', array_merge(
            compact('company', 'typeCompanies'),
            $this->formOptions(),
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = new Company();
        $company->fill($request->validated());
        $company->account_id = auth()->user()->account_id;
        $company->save();

        $company->contacts()->sync($this->accountContactIds($request));

        return redirect()
            ->route('company.show', ['company' => $company, 'typeCompanies' => $company->type])
            ->with('success', 'Organização criada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Request $request)
    {
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
    public function edit(Company $company, Request $request)
    {
        $typeCompanies = $request->input('typeCompanies', $company->type);

        return view('sales.companies.editCompany', array_merge(
            compact('company', 'typeCompanies'),
            $this->formOptions(),
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->fill($request->validated());
        $company->save();

        $company->contacts()->sync($this->accountContactIds($request));

        return redirect()
            ->route('company.show', ['company' => $company, 'typeCompanies' => $company->type])
            ->with('success', 'Organização atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $typeCompanies = $company->type;
        $company->delete();

        return redirect()->route('company.index', compact(
            'typeCompanies',
        ));
    }

    /**
     * Opções dos selects do formulário de criar/editar.
     */
    private function formOptions()
    {
        return [
            'contacts' => Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('name', 'ASC')
                ->get(['id', 'name']),
            'states' => array_filter(returnStates()),
            'types' => Company::returnTypes(),
            'statuses' => Company::STATUSES,
            'sectors' => Company::SECTORS,
            'businessModelTypes' => Company::businessModelTypes(),
        ];
    }

    /**
     * Ids de contatos enviados no formulário, limitados aos da conta do usuário.
     */
    private function accountContactIds(Request $request)
    {
        return Contact::where('account_id', auth()->user()->account_id)
            ->whereIn('id', (array) $request->input('contacts', []))
            ->pluck('id')
            ->toArray();
    }
}
