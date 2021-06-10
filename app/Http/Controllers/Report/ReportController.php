<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Account;
use App\Models\AccountReport;
use App\Models\Company;
use App\Models\CompetitorReport;
use App\Models\Socialmedia;
use App\Models\SocialmediaReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$reports = Report::whereHas('account', function ($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->with([
					'accountReport',
					'socialmediaReports.socialmedia',
					'competitorReports.company',
				])
				->paginate(20);
//		dd($reports);
		$totalReports = $reports->count();

		return view('reports.indexReports', compact(
						'reports',
						'totalReports',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$accounts = Account::whereHas('users', function ($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->get();

		return view('reports.createReport', compact(
						'accounts'
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$report = new Report();
		$report->fill($request->all());
		$report->save();

		//gera um relatório de account
		$accountReport = new AccountReport();
		$accountReport->account_id = $report->account_id;
		$accountReport->report_id = $report->id;
		if ($report->account->cnpj) {
			$accountReport->cnpj = 1;
		} else {
			$accountReport->cnpj = 0;
		}
		if ($report->account->logo) {
			$accountReport->logo = 1;
		} else {
			$accountReport->logo = 0;
		}
		if ($report->account->principal_color !== null
				AND
				$report->account->complementary_color !== null
				AND
				$report->account->opposite_color !== null) {
			$accountReport->pallet = 1;
		} else {
			$accountReport->pallet = 0;
		}
		$accountReport->save();
		
			//gera um relatório de social media
		$socialmedias = Socialmedia::where('account_id', $report->account_id)
				->get();

		foreach ($socialmedias as $socialmedia) {
			$fields = $socialmedia->getAttributes();
			unset($fields['id']);
			$socialmediaReport = new SocialmediaReport();
			$socialmediaReport->fill($fields);
			$socialmediaReport->account_id = $report->account_id;
			$socialmediaReport->report_id = $report->id;
			$socialmediaReport->socialmedia_id = $socialmedia->id;
			$socialmediaReport->save();
		}

		//gera um relatório de company
		$companies = Company::where('account_id', $report->account_id)
				->where('type', 'concorrente')
				->get();

		foreach ($companies as $company) {
			$fields = $company->getAttributes();
			unset($fields['id']);
			$competitorReport = new CompetitorReport();
			$competitorReport->fill($fields);
			$competitorReport->account_id = $report->account_id;
			$competitorReport->report_id = $report->id;
			$competitorReport->company_id = $company->id;
//dd($competitorReport);
			$competitorReport->save();
		}


		return redirect()->route('report.show', compact('report'));
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function show(Report $report) {
//		dd($report);
		$socialmediaReports = SocialmediaReport::where('report_id', $report->id)
				->where('type', '!=', 'concorrente')
				->get();
//		dd($socialmediaReports);
		$socialmediasCompetitorsReports = SocialmediaReport::where('report_id', $report->id)
				->where('type', '=', 'concorrente')
				->with('socialmedia')
				->get();
//dd($socialmediasCompetitorsReports);
		return view('reports.showReport', compact(
						'report',
						'socialmediaReports',
						'socialmediasCompetitorsReports',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Report $report) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function ($query) use ($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function ($query) use ($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('reports.editReport', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'report' => $report,
			]);
		} else {
			return redirect('/');
		}

		return view('reports.editReport', [
			'userAuth' => $userAuth,
			'report' => $report,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Report $report) {
		$report->fill($request->all());
		$report->save();

		return redirect()->route('report.show', compact('report'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Report $report) {
		$report->delete();
		return redirect()->route('report.index');
	}

	public function generatePDF(Report $report) {

		$pdf = PDF::loadView('reports.showReport', $report);
//		    $pdf = PDF::loadView('licencie_structure.show', compact('licencie'));
		$pdf->loadHTML('<h1>Test</h1>');
		$pdf->save(storage_path() . '_relatorio.pdf');
		$pdf->download('relatorio.pdf');
	}

	public function showSocialmediaReport($socialmediaReports) {

		foreach ($socialmediaReports as $socialmediaReport) {

			echo"<div class='facebook'>";
			echo"<div style='display: inline-block'>";
			echo"<img class='grid-image' src='" . asset('imagens/facebook.png') . "' style='width: 80px;height: 80px;text-align: left'>";
			echo"</div>";
			echo"<div style='display: inline-block'>";
			$socialmediaReport->socialmedia->socialmedia_name;
			echo"<br>";
			$socialmediaReport->socialmedia->name;
			echo"<br>";
			$socialmediaReport->socialmedia->URL_name;
			echo"</div>";
			echo"</div>";
			echo"<br>";

			echo "<div class = row>";
			echo "<div  class='col-11' style='border-bottom: 1px; border-bottom-style: solid'>";
			echo"Possui conta bussiness:;";
			echo "</div>";
			if ($socialmediaReport->bussiness === 1) {
				echo "<div class='col-1 btn btn-info' style='padding: 0.5rem 2rem;text-align: center ' >SIM";
			} else {
				echo"<div class= 'col-1 btn btn-danger' style='padding: 0.5rem 2rem;text-align: center'>NÃO";
			}
			echo "</div></div>";

			echo"<div class='row'>";
			echo"<div>";
			echo"<p style='font-style:italic;text-align: justify'><br>";
			echo"<br>";
			if ($socialmediaReport->bussiness === 1) {
				echo "Muito bem! Nossa análise indicou que essa etapa está concluída e que você está maduro digitalmente! 
				Talvez você ainda não seja um expert e é sempre possível colher mais dados para melhorar sua performance
				e tráfego.";
			} else {
				echo "Quando você usa um perfil de negócios (conta business – conta empresa) você potencializa o seu negócio, 
				melhora a sua autoridade e se beneficia dos recursos adicionais que não são disponibilizados nas contas pessoais,
				como: botões de ação, análises métricas, anunciar produtos através de ADS, entre outros.";
			}

			echo"</p>";
			echo"</div>";
			echo"</div>";
		}
	}

}
