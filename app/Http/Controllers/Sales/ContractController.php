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
					'user',
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
		$contract->text = ContractTemplate::find($request->contractTemplate_id)->pluck('text');
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
		
		$userContact = userContact($contract->user_id);
		
		return view('sales.contracts.showContract', compact(
						'contract',
						'accounts',
						'users',
						'opportunities',
						'contacts',
						'userContact',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contract $contract) {
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

		$userContact = userContact($contract->user_id);

		return view('sales.contracts.showContract', compact(
						'contract',
						'userContact',
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

//		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
//				->with('product', 'opportunity')
//				->get();
		
		$data = [
			'accountLogo' => $contract->account->logo,
			'accountName' => $contract->account->name,
			'accountEmail' => $contract->account->email,
			'accountPhone' => $contract->account->phone,
			'accountAddress' => $contract->account->address,
			'accountAddressCity' => $contract->account->address_city,
			'accountAddressState' => $contract->account->address_state,
			'accountCnpj' => $contract->account->cnpj,
			'contractId' => $contract->id,
			'contractObservations' => $contract->observations,
			'contractText' => $contract->text,
//			'invoiceDiscount' => $invoice->discount,
			'contractDateDue' => $contract->date_due,
//			'invoiceTotalPrice' => $invoice->totalPrice,
			'customerName' => $contract->contact->name,
			'customerEmail' => $contract->contact->email,
			'customerPhone' => $contract->contact->phone,
			'customerAddress' => $contract->contact->address,
			'customerCity' => $contract->contact->city,
			'customerState' => $contract->contact->state,
			'customerCountry' => $contract->contact->country,
//			'invoiceLines' => $invoiceLines,
//			'deadline' => $deadline,
		];

		$pdf = PDF::loadView('sales.contracts.pdfContract', compact('data'));

// download PDF file with download method
		return $pdf->stream('fatura.pdf');
	}

}
