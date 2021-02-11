<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Opportunity;
use App\Models\User;

class ContractController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$accountsId = userAccounts();

		$contracts = Contract::whereIn('account_id', $accountsId)
				->with([
					'contact',
					'account',
					'company',
					'opportunity',
					'user',
					'userContact',
					'invoice.invoiceLines.product',
				])
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$totalContracts = $contracts->count();

		return view('sales.contracts.indexContracts', compact(
						'contracts',
						'totalContracts',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$contract = new Contract();

		$accountsId = userAccounts();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('accounts.id', $accountsId);
				})
				->get();

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$invoices = Invoice::whereIn('account_id', $accountsId)
				->orderBy('IDENTIFIER', 'DESC')
				->get();

		$opportunities = Opportunity::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$contractsTemplates = ContractTemplate::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$companies = Company::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		return view('sales.contracts.createContract', compact(
						'contract',
						'accounts',
						'users',
						'invoices',
						'opportunities',
						'contacts',
						'contractsTemplates',
						'companies',
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$contract = new Contract;
		$contract->fill($request->all());
		$contractTemplate = ContractTemplate::find($request->contractTemplate_id)->first();
		$contract->text = $contractTemplate->text;
		$contract->save();

		return redirect()->action('Sales\\ContractController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function show(Contract $contract) {
		$accountsId = userAccounts();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('accounts.id', $accountsId);
				})
				->get();

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$opportunities = Opportunity::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$invoiceLines = InvoiceLine::where('invoice_id', $contract->invoice_id)
				->with('product', 'opportunity')
				->get();

		$userContact = userContact($contract->user_id);

		$witness1 = Contact::find($contract->witness1);
		$witnessName1 = $witness1->name;

		$witness2 = Contact::find($contract->witness2);
		$witnessName2 = $witness2->name;

		return view('sales.contracts.showContract', compact(
						'contract',
						'accounts',
						'users',
						'opportunities',
						'contacts',
						'invoiceLines',
						'userContact',
						'witnessName1',
						'witnessName2',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contract $contract) {
		$contract = Contract::find($contract->id)
				->with('opportunity')
				->first();

		$accountsId = userAccounts();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$companies = Company::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$invoices = Invoice::whereIn('account_id', $accountsId)
				->orderBy('ID', 'DESC')
				->pluck('id')
				->toArray();

		$witness1 = Contact::find($contract->witness1);
		$witnessName1 = $witness1->name;

		$witness2 = Contact::find($contract->witness2);
		$witnessName2 = $witness2->name;

		$opportunities = Opportunity::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$contractsTemplates = ContractTemplate::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('accounts.id', $accountsId);
				})
				->get();

		$userContact = userContact($contract->user_id);

		return view('sales.contracts.editContract', compact(
						'contract',
						'accounts',
						'opportunities',
						'contacts',
						'companies',
						'invoices',
						'witnessName1',
						'witnessName2',
						'contractsTemplates',
						'users',
						'userContact',
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Contract $contract) {
		$contract->fill($request->all());
		$contract->save();

		$invoiceLines = InvoiceLine::where('invoice_id', $contract->invoice_id)
				->with('product', 'opportunity')
				->get();

		$userContact = userContact($contract->user_id);

		$witness1 = Contact::find($contract->witness1);
		$witnessName1 = $witness1->name;

		$witness2 = Contact::find($contract->witness2);
		$witnessName2 = $witness2->name;

		return view('sales.contracts.showContract', compact(
						'contract',
						'invoiceLines',
						'userContact',
						'witnessName1',
						'witnessName2',
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Contract $contract) { {
			$contract->delete();
			return redirect()->action('Sales\\ContractController@index');
		}
	}

// Generate PDF
	public function createPDF(Contract $contract) {

		$invoice = Invoice::where('id', $contract->invoice_id)
//				->with('product', 'opportunity')
				->get();

		$invoiceLines = InvoiceLine::where('invoice_id', $contract->invoice_id)
				->with('product', 'opportunity')
				->get();

		$witness1 = Contact::find($contract->witness1);
		$witnessName1 = $witness1->name;

		$witness2 = Contact::find($contract->witness2);
		$witnessName2 = $witness2->name;

		$data = [
			// dados da empresa contratada
			'accountLogo' => $contract->account->logo,
			'accountName' => $contract->account->name,
			'accountId' => $contract->account->id,
			'accountEmail' => $contract->account->email,
			'accountPhone' => $contract->account->phone,
			'accountAddress' => $contract->account->address,
			'accountCity' => $contract->account->city,
			'accountState' => $contract->account->state,
			'accountZipCode' => $contract->account->zip_code,
			'accountCnpj' => $contract->account->cnpj,
			// dados do RESPONSAVEL pela empresa contratada
			'userName' => $contract->user->contact->name,
			'userId' => $contract->user->id,
			'userAddress' => $contract->user->contact->address,
			'userCity' => $contract->user->contact->city,
			'userState' => $contract->user->contact->state,
			'userZipCode' => $contract->user->contact->zip_code,
			'userCpf' => $contract->user->contact->cpf,
			// dados da empresa contratante
			'companyName' => $contract->company->name,
			'companyId' => $contract->company->id,
			'companyAddress' => $contract->company->address,
			'companyCity' => $contract->company->city,
			'companyState' => $contract->company->state,
			'companyZipCode' => $contract->company->zip_code,
			'companyCnpj' => $contract->company->cnpj,
			// dados do RESPONSAVEL pela empresa contratante
			'contactName' => $contract->contact->name,
			'contactId' => $contract->contact->id,
			'contactAddress' => $contract->contact->address,
			'contactCity' => $contract->contact->city,
			'contactState' => $contract->contact->state,
			'contactZipCode' => $contract->contact->zip_code,
			'contactCpf' => $contract->contact->cpf,
			// dados do Contrato
			'contractId' => $contract->id,
			'contractObservations' => $contract->observations,
			'contractName' => $contract->name,
			'contractText' => $contract->text,
			'contractDateDue' => $contract->date_due,
			'contractDateStart' => $contract->date_start,
			'contractWitness1' => $witnessName1,
			'contractWitness2' => $witnessName2,
			// outros dados
			'invoiceDiscount' => $contract->invoice->discount,
			'invoiceInstallmentValue' => $contract->invoice->installment_value,
			'invoiceNumberInstallmentTotal' => $contract->invoice->number_installment_total,
			'invoiceTotalPrice' => $contract->invoice->totalPrice,
			'customerName' => $contract->contact->name,
			'customerEmail' => $contract->contact->email,
			'customerPhone' => $contract->contact->phone,
			'customerAddress' => $contract->contact->address,
			'customerCity' => $contract->contact->city,
			'customerState' => $contract->contact->state,
			'customerCountry' => $contract->contact->country,
			'invoiceLines' => $invoiceLines,
//			'deadline' => $deadline,
		];
		
		$pdf = PDF::loadView('sales.contracts.pdfContract', compact('data'));

// download PDF file with download method
		return $pdf->stream('fatura.pdf');
	}

}
